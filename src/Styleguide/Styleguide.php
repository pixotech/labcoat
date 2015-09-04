<?php

namespace Labcoat\Styleguide;

use Labcoat\Assets\AssetDirectory;
use Labcoat\PatternLab;
use Labcoat\PatternLabInterface;
use Labcoat\Patterns\PatternCollection;
use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PatternSubTypeInterface;
use Labcoat\Patterns\PatternTypeInterface;
use Labcoat\Styleguide\Files\AnnotationsFile;
use Labcoat\Styleguide\Files\AssetFile;
use Labcoat\Styleguide\Files\DataFile;
use Labcoat\Styleguide\Files\FileInterface;
use Labcoat\Styleguide\Files\LatestChangeFile;
use Labcoat\Styleguide\Files\PageFile;
use Labcoat\Styleguide\Files\PatternSourceFile;
use Labcoat\Styleguide\Files\PatternTemplateFile;
use Labcoat\Styleguide\Files\StyleguideAssetFile;
use Labcoat\Styleguide\Navigation\Navigation;
use Labcoat\Styleguide\Navigation\Pattern as NavigationPattern;
use Labcoat\Styleguide\Pages\PatternPage;
use Labcoat\Styleguide\Pages\PatternPageInterface;
use Labcoat\Styleguide\Pages\StyleguideIndexPage;
use Labcoat\Styleguide\Pages\SubTypeIndexPage;
use Labcoat\Styleguide\Pages\TypeIndexPage;

class Styleguide implements StyleguideInterface {

  protected $assets;

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
  protected $patternData = [];

  /**
   * @var \Labcoat\PatternLabInterface
   */
  protected $patternlab;

  /**
   * @var array
   */
  protected $patternPaths = [];

  /**
   * @var array
   */
  protected $patterns = [];

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
    $this->patternlab = $patternlab;
    $this->cacheBuster = time();
    $this->indexPage = new StyleguideIndexPage($this);
    $this->assetsDirectory = $patternlab->getStyleguideAssetsDirectory();
    $this->headerTemplatePath = $patternlab->getStyleguideHeader();
    $this->footerTemplatePath = $patternlab->getStyleguideFooter();
    $this->templatesDirectory = $patternlab->getStyleguideTemplatesDirectory();
    $this->loadConfig($patternlab);
    $this->loadControls($patternlab);
    $this->addPatterns($patternlab->getPatterns());
    $this->findAssets($patternlab);
    $this->makeFiles($patternlab);
    unset($this->pages);
    unset($this->indexPage);
  }

  public function generate($directory) {
    foreach ($this->files as $path => $file) {
      $destination = PatternLab::makePath([$directory, $path]);
      $this->ensurePathDirectory($destination);
      $file->put($this, $destination);
    }
  }

  /**
   * @return int
   */
  public function getCacheBuster() {
    return $this->cacheBuster;
  }

  /**
   * @return array
   */
  public function getConfig() {
    return $this->config;
  }

  /**
   * @return array
   */
  public function getControls() {
    return $this->controls;
  }

  public function getFiles() {
    return $this->files;
  }

  /**
   * @return array
   */
  public function getIndexPaths() {
    return $this->indexPaths;
  }

  /**
   * @return Navigation
   */
  public function getNavigation() {
    return $this->navigation;
  }

  public function getPatternData(\Labcoat\Styleguide\Patterns\PatternInterface $pattern) {
    $id = $pattern->getId();
    if (!isset($this->patternData[$id])) {
      if ($pattern->isPseudo()) {
        $parent = $this->patternlab->getPattern($pattern->getParentId());
        $source = $parent->getPseudoPatterns()[$pattern->getVariantName()];
        $data = $this->patternData[$pattern->getParentId()];
        $data = array_replace_recursive($data, $source->getData()->getData());
      }
      else {
        $data = $this->getGlobalData();
        $source = $this->patternlab->getPattern($pattern->getId());
        foreach ($source->getData() as $patternData) {
          $data = array_replace_recursive($data, $patternData->getData());
        }
      }
      $this->patternData[$id] = $data;
    }
    return $this->patternData[$id];
  }

  /**
   * @return array
   */
  public function getPatternPaths() {
    return $this->patternPaths;
  }

  /**
   * @return array
   */
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

  public function renderPattern(\Labcoat\Styleguide\Patterns\PatternInterface $pattern) {
    $id = $pattern->getId();
    if (!isset($this->patterns[$id])) {
      $template = $pattern->getTemplate();
      $data = $this->getPatternData($pattern);
      $this->patterns[$id] = $this->patternlab->render($template, $data);
    }
    return $this->patterns[$id];
  }

  /**
   * @param FileInterface $file
   */
  protected function addFile(FileInterface $file) {
    $this->files[$file->getPath()] = $file;
  }

  /**
   * @param PatternInterface $pattern
   */
  protected function addPattern(PatternInterface $pattern) {
    $this->pages[$pattern->getId()] = new PatternPage($pattern);
    $this->getIndexPage()->addPattern($pattern);
    if (isset($this->pages[$pattern->getTypeId()])) {
      $this->getTypePage($pattern->getTypeId())->addPattern($pattern);
    }
    if ($pattern->hasSubType()) {
      $this->getSubtypePage($pattern->getSubTypeId())->addPattern($pattern);
    }
    $this->navigation->addPattern($pattern);
    $this->addPatternPath($pattern);
  }

  /**
   * @param PatternInterface $pattern
   */
  protected function addPatternPath(PatternInterface $pattern) {
    $typeName = PatternLab::stripDigits($pattern->getType());
    $patternName = PatternLab::stripDigits($pattern->getName());
    $navPattern = new NavigationPattern($pattern);
    $this->patternPaths[$typeName][$patternName] = dirname($navPattern->getPath());
  }

  /**
   * @param PatternCollection $patterns
   */
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

  /**
   * @param PatternSubTypeInterface $subtype
   */
  protected function addSubtype(PatternSubTypeInterface $subtype) {
    $this->pages[$subtype->getId()] = new SubTypeIndexPage($subtype);
    $this->navigation->addSubtype($subtype);
    $this->addSubtypeIndexPath($subtype);
  }

  /**
   * @param PatternSubTypeInterface $subtype
   */
  protected function addSubtypeIndexPath(PatternSubTypeInterface $subtype) {
    $type = $subtype->getType();
    $typeName = PatternLab::stripDigits($type->getName());
    $subtypeName = PatternLab::stripDigits($subtype->getName());
    if (!isset($this->indexPaths[$typeName])) {
      $this->indexPaths[$typeName] = ['all' => $type->getName()];
    }
    $this->indexPaths[$typeName][$subtypeName] = $type->getName() . '-' . $subtype->getName();
  }

  /**
   * @param PatternTypeInterface $type
   */
  protected function addType(PatternTypeInterface $type) {
    if ($type->hasSubtypes()) {
      $this->pages[$type->getId()] = new TypeIndexPage($type);
    }
    $this->navigation->addType($type);
  }

  /**
   * @param $path
   */
  protected function ensureDirectory($path) {
    if (!is_dir($path)) mkdir($path, 0777, true);
  }

  /**
   * @param $path
   */
  protected function ensurePathDirectory($path) {
    $this->ensureDirectory(dirname($path));
  }


  protected function findAssets(PatternLabInterface $patternlab) {
    $assets = new AssetDirectory($patternlab, $this->assetsDirectory);
    $this->assets = $assets->getAssets();
  }

  protected function getGlobalData() {
    if (!isset($this->globalData)) $this->globalData = $this->patternlab->getGlobalData();
    return $this->globalData;
  }

  /**
   * @return \Labcoat\Styleguide\Pages\StyleguideIndexPageInterface
   */
  protected function getIndexPage() {
    return $this->indexPage;
  }

  /**
   * @return array
   */
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
   * @return \Labcoat\Styleguide\Pages\PageInterface
   */
  protected function getPage($id) {
    return $this->pages[$id];
  }

  /**
   * @return string
   */
  protected function getPatternFooterTemplatePath() {
    return $this->footerTemplatePath;
  }

  /**
   * @return string
   */
  protected function getPatternHeaderTemplatePath() {
    return $this->headerTemplatePath;
  }

  /**
   * @param $template
   * @return string
   */
  protected function getStyleguideTemplateContent($template) {
    return file_get_contents($this->getStyleguideTemplatePath($template));
  }

  /**
   * @param $template
   * @return string
   */
  protected function getStyleguideTemplatePath($template) {
    return PatternLab::makePath([$this->templatesDirectory, $template]);
  }

  /**
   * @return array
   */
  protected function getStylesheets() {
    return [];
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
   * @param PatternLabInterface $patternlab
   */
  protected function loadConfig(PatternLabInterface $patternlab) {
    $this->config = $patternlab->getExposedOptions();
  }

  /**
   * @param PatternLabInterface $patternlab
   */
  protected function loadControls(PatternLabInterface $patternlab) {
    $this->controls = [
      'ishControlsHide' => [],
      'mqs' => $this->getMediaQueries(),
    ];
    foreach ($patternlab->getHiddenControls() as $control) {
      $this->controls['ishControlsHide'][$control] = 'true';
    }
  }

  protected function makeAnnotationsFile() {
    if ($path = $this->patternlab->getAnnotationsFile()) {
      $this->addFile(new AnnotationsFile($path));
    }
  }

  protected function makeAssetFiles(PatternLabInterface $patternlab) {
    foreach ($patternlab->getAssets() as $asset) {
      $this->addFile(new AssetFile($asset));
    }
    foreach ($this->assets as $asset) {
      $this->addFile(new StyleguideAssetFile($asset));
    }
  }

  protected function makeDataFile() {
    $this->addFile(new DataFile($this->navigation));
  }

  protected function makeFiles(PatternLabInterface $patternlab) {
    $this->makeDataFile();
    $this->makePageFiles();
    $this->makeAssetFiles($patternlab);
    $this->makeAnnotationsFile();
    $this->makeLatestChangeFile();
  }

  protected function makeLatestChangeFile() {
    $this->addFile(new LatestChangeFile(time()));
  }

  protected function makePageFiles() {
    $this->addFile(new PageFile($this->indexPage));
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

  /**
   * @param $path
   * @param $content
   */
  protected function writeFile($path, $content) {
    $this->ensurePathDirectory($path);
    file_put_contents($path, $content);
  }
}