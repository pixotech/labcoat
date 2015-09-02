<?php

namespace Labcoat\Styleguide;

use Labcoat\Configuration\Configuration;
use Labcoat\PatternLab;
use Labcoat\PatternLabInterface;
use Labcoat\Patterns\PatternCollection;
use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PatternSubTypeInterface;
use Labcoat\Patterns\PatternTypeInterface;
use Labcoat\Styleguide\Files\DataFile;
use Labcoat\Styleguide\Files\FileInterface;
use Labcoat\Styleguide\Files\PageFile;
use Labcoat\Styleguide\Files\PatternSourceFile;
use Labcoat\Styleguide\Files\PatternTemplateFile;
use Labcoat\Styleguide\Navigation\Navigation;
use Labcoat\Styleguide\Navigation\Pattern as NavigationPattern;
use Labcoat\Styleguide\Pages\PatternPage;
use Labcoat\Styleguide\Pages\PatternPageInterface;
use Labcoat\Styleguide\Pages\StyleguideIndexPage;
use Labcoat\Styleguide\Pages\SubTypeIndexPage;
use Labcoat\Styleguide\Pages\TypeIndexPage;

class Styleguide implements StyleguideInterface {

  /**
   * @var string
   */
  protected $assetsDirectory;

  /**
   * @var int
   */
  protected $cacheBuster;

  /**
   * @var array
   */
  protected $config;

  /**
   * @var array
   */
  protected $controls;

  /**
   * @var string
   */
  protected $destinationPath;

  /**
   * @var \Labcoat\Styleguide\Files\FileInterface[]
   */
  protected $files = [];

  /**
   * @var string
   */
  protected $footerTemplatePath;

  /**
   * @var array|null
   */
  protected $globalData;

  /**
   * @var string
   */
  protected $headerTemplatePath;

  /**
   * @var \Labcoat\Styleguide\Pages\StyleguideIndexPageInterface
   */
  protected $indexPage;

  /**
   * @var array
   */
  protected $indexPaths = [];

  /**
   * @var Navigation
   */
  protected $navigation;

  /**
   * @var \Labcoat\Styleguide\Pages\PageInterface[]
   */
  protected $pages;

  /**
   * @var array
   */
  protected $patternPaths = [];

  /**
   * @var string
   */
  protected $templatesDirectory;

  /**
   * @var \Twig_Environment
   */
  protected $twig;

  /**
   * @param PatternLabInterface $patternlab
   */
  public function __construct(PatternLabInterface $patternlab) {
    $this->cacheBuster = time();
    $this->indexPage = new StyleguideIndexPage($this);
    $this->assetsDirectory = $patternlab->getStyleguideAssetsDirectory();
    $this->headerTemplatePath = $patternlab->getStyleguideHeader();
    $this->footerTemplatePath = $patternlab->getStyleguideFooter();
    $this->templatesDirectory = $patternlab->getStyleguideTemplatesDirectory();
    $this->loadConfig($patternlab);
    $this->loadControls($patternlab);
    $this->addPatterns($patternlab->getPatterns());
    $this->makeFiles();
  }

  public function generate() {
  }

  public function getCacheBuster() {
    return $this->cacheBuster;
  }

  public function getConfig() {
    return $this->config;
  }

  public function getControls() {
    return $this->controls;
  }

  public function getIndexPaths() {
    return $this->indexPaths;
  }

  public function getNavigation() {
    return $this->navigation;
  }

  public function getPatternExample(PatternInterface $pattern) {
  }

  public function getPatternExampleData(PatternInterface $pattern) {
    return $pattern->getData();
  }

  public function getPatternPaths() {
    return $this->patternPaths;
  }

  public function getPlugins() {
    return [];
  }

  /**
   * @return \Twig_Environment
   */
  public function getTwig() {
    if (!isset($this->twig)) $this->makeTwig();
    return $this->twig;
  }

  protected function addFile(FileInterface $file) {
    $this->files[$file->getPath()] = $file;
  }

  protected function addPattern(PatternInterface $pattern) {
    $this->pages[$pattern->getId()] = new PatternPage($this, $pattern);
    $this->getIndexPage()->addPattern($pattern);
    $this->getTypePage($pattern->getTypeId())->addPattern($pattern);
    if ($pattern->hasSubType()) $this->getSubtypePage($pattern->getSubTypeId())->addPattern($pattern);
    $this->navigation->addPattern($pattern);
    $this->addPatternPath($pattern);
  }

  protected function addPatternPath(PatternInterface $pattern) {
    $typeName = PatternLab::stripDigits($pattern->getType());
    $patternName = PatternLab::stripDigits($pattern->getName());
    $navPattern = new NavigationPattern($pattern);
    $this->patternPaths[$typeName][$patternName] = dirname($navPattern->getPath());
  }

  protected function addPatterns(PatternCollection $patterns) {
    $this->navigation = new Navigation();
    $items = new \RecursiveIteratorIterator($patterns, \RecursiveIteratorIterator::SELF_FIRST);
    foreach ($items as $item) {
      if ($item instanceof PatternTypeInterface) {
        $this->addType($item);
      }
      elseif ($item instanceof PatternSubTypeInterface) {
        $this->addSubtype($item);
      }
      elseif ($item instanceof PatternInterface) {
        $this->addPattern($item);
      }
    }
  }

  protected function addSubtype(PatternSubTypeInterface $subtype) {
    $this->pages[$subtype->getId()] = new SubTypeIndexPage($this, $subtype);
    $this->navigation->addSubtype($subtype);
    $this->addSubtypeIndexPath($subtype);
  }

  protected function addSubtypeIndexPath(PatternSubTypeInterface $subtype) {
    $type = $subtype->getType();
    $typeName = PatternLab::stripDigits($type->getName());
    $subtypeName = PatternLab::stripDigits($subtype->getName());
    if (!isset($this->indexPaths[$typeName])) {
      $this->indexPaths[$typeName] = ['all' => $type->getName()];
    }
    $this->indexPaths[$typeName][$subtypeName] = $type->getName() . '-' . $subtype->getName();
  }

  protected function addType(PatternTypeInterface $type) {
    $this->pages[$type->getId()] = new TypeIndexPage($this, $type);
    $this->navigation->addType($type);
  }

  protected function ensureDirectory($path) {
    if (!is_dir($path)) mkdir($path, 0777, true);
  }

  protected function ensurePathDirectory($path) {
    $this->ensureDirectory(dirname($path));
  }

  /**
   * @return \Labcoat\Styleguide\Pages\StyleguideIndexPageInterface
   */
  protected function getIndexPage() {
    return $this->indexPage;
  }

  protected function getMediaQueries() {
    $mediaQueries = [];
    foreach ($this->getStylesheets() as $path) {
      $data = file_get_contents($path);
      preg_match_all("/@media.*(min|max)-width:([ ]+)?(([0-9]{1,5})(\.[0-9]{1,20}|)(px|em))/", $data, $matches);
      foreach ($matches[3] as $match) {
        if (!in_array($match, $mediaQueries)) {
          $mediaQueries[] = $match;
        }
      }
    }
    usort($mediaQueries, "strnatcmp");
    return $mediaQueries;
  }

  /**
   * @param string $id
   * @return \Labcoat\Styleguide\Pages\SubTypeIndexPageInterface
   */
  protected function getSubtypePage($id) {
    return $this->getPage($id);
  }

  /**
   * @param string $id
   * @return \Labcoat\Styleguide\Pages\TypeIndexPageInterface
   */
  protected function getTypePage($id) {
    return $this->getPage($id);
  }

  /**
   * @param string $id
   * @return \Labcoat\Styleguide\Pages\PageInterface
   */
  protected function getPage($id) {
    return $this->pages[$id];
  }

  protected function getPatternFooterTemplatePath() {
    return $this->footerTemplatePath;
  }

  protected function getPatternHeaderTemplatePath() {
    return $this->headerTemplatePath;
  }

  protected function getStyleguideTemplateContent($template) {
    return file_get_contents($this->getStyleguideTemplatePath($template));
  }

  protected function getStyleguideTemplatePath($template) {
    return Configuration::makePath([$this->templatesDirectory, $template]);
  }

  protected function getStylesheets() {
    return [];
  }

  protected function loadConfig(PatternLabInterface $patternlab) {
    $this->config = $patternlab->getExposedOptions();
  }

  protected function loadControls(PatternLabInterface $patternlab) {
    $this->controls = [
      'ishControlsHide' => [],
      'mqs' => $this->getMediaQueries(),
    ];
    foreach ($patternlab->getHiddenControls() as $control) {
      $this->controls['ishControlsHide'][$control] = 'true';
    }
  }

  protected function loadGlobalData() {
    $this->globalData = [];
  }

  protected function makeDataFile() {
    $this->addFile(new DataFile($this->navigation));
  }

  protected function makeFiles() {
    $this->makeDataFile();
    $this->makePageFiles();
  }

  protected function makePageFiles() {
    foreach ($this->pages as $page) {
      $this->addFile(new PageFile($page));
      if ($page instanceof PatternPageInterface) {
        $this->addFile(new PatternSourceFile($page->getPattern()));
        $this->addFile(new PatternTemplateFile($page->getPattern()));
      }
    }
  }

  protected function makeTwig() {
    $templates = [
      'partials/general-footer' => $this->getStyleguideTemplateContent('partials/general-footer.twig'),
      'partials/general-header' => $this->getStyleguideTemplateContent('partials/general-header.twig'),
      'patternSection.twig' => $this->getStyleguideTemplateContent('partials/patternSection.twig'),
      'patternSectionSubtype.twig' => $this->getStyleguideTemplateContent('partials/patternSectionSubtype.twig'),
      'viewall' => $this->getStyleguideTemplateContent('viewall.twig'),
    ];
    $templates['patternLabHead'] = file_get_contents($this->getPatternHeaderTemplatePath());
    $templates['patternLabFoot'] = file_get_contents($this->getPatternFooterTemplatePath());
    $loader = new \Twig_Loader_Array($templates);
    $this->twig = new \Twig_Environment($loader, ['cache' => false]);
  }

  protected function writeFile($path, $content) {
    $this->ensurePathDirectory($path);
    file_put_contents($path, $content);
  }
}