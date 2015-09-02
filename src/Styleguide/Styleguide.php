<?php

namespace Labcoat\Styleguide;

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
use Labcoat\Styleguide\Files\PatternHtmlFile;
use Labcoat\Styleguide\Files\PatternTemplateFile;
use Labcoat\Styleguide\Navigation\Navigation;
use Labcoat\Styleguide\Navigation\Pattern as NavigationPattern;
use Labcoat\Styleguide\Pages\PatternPage;
use Labcoat\Styleguide\Pages\PatternPageInterface;
use Labcoat\Styleguide\Pages\StyleguideIndexPage;
use Labcoat\Styleguide\Pages\SubTypeIndexPage;
use Labcoat\Styleguide\Pages\TypeIndexPage;

class Styleguide implements StyleguideInterface {

  protected $cacheBuster;

  protected $data;

  protected $destinationPath;

  /**
   * @var \Labcoat\Styleguide\Files\FileInterface[]
   */
  protected $files = [];

  protected $globalData;

  protected $indexFiles;

  /**
   * @var \Labcoat\Styleguide\Pages\StyleguideIndexPageInterface
   */
  protected $indexPage;

  protected $indexPaths = [];

  /**
   * @var Navigation
   */
  protected $navigation;

  /**
   * @var \Labcoat\Styleguide\Pages\PageInterface[]
   */
  protected $pages;

  protected $patternFileSets;

  protected $patternlab;

  protected $patternPaths = [];

  protected $patterns;

  protected $subtypePatterns;

  protected $twig;

  protected $typePatterns;

  public function __construct(PatternLabInterface $patternlab) {
    #$this->patternlab = $patternlab;
    $this->cacheBuster = time();
    $this->indexPage = new StyleguideIndexPage($this);
    $this->addPatterns($patternlab->getPatterns());
    $this->makeFiles();
  }

  public function generate() {
    $this->makePatternPages();
  }

  public function getCacheBuster() {
    return $this->cacheBuster;
  }

  public function getData() {
    return $this->data;
  }

  public function getDataFileContents() {
    $contents  = "var config = " . json_encode($this->getConfig()).";";
    $contents .= "var ishControls = " . json_encode($this->getControls()) . ";";
    $contents .= "var navItems = " . json_encode($this->navigation) . ";";
    $contents .= "var patternPaths = " . json_encode($this->getPatternPaths()) . ";";
    $contents .= "var viewAllPaths = " . json_encode($this->getIndexPaths()) . ";";
    $contents .= "var plugins = " . json_encode($this->getPlugins()) . ";";
    return $contents;
  }

  public function getIndexPaths() {
    return $this->indexPaths;
  }

  public function getNavigation() {
    return $this->navigation;
  }

  public function getPatternExample(PatternInterface $pattern) {
    $path = $pattern->getPath();
    $data = $this->getPatternExampleData($pattern);
    return $this->patternlab->render($path, $data);
  }

  public function getPatternExampleData(PatternInterface $pattern) {
    return $pattern->getData();
  }

  public function getPatternLab() {
    return $this->patternlab;
  }

  public function getPatternPaths() {
    return $this->patternPaths;
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

  protected function addPatternPath(PatternInterface $pattern) {
    $typeName = PatternLab::stripDigits($pattern->getType());
    $patternName = PatternLab::stripDigits($pattern->getName());
    $navPattern = new NavigationPattern($pattern);
    $this->patternPaths[$typeName][$patternName] = dirname($navPattern->getPath());
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

  protected function ensureDirectory($path) {
    if (!is_dir($path)) mkdir($path, $this->patternlab->getDefaultDirectoryPermissions(), true);
  }

  protected function ensurePathDirectory($path) {
    $this->ensureDirectory(dirname($path));
  }

  protected function getPatternData(PatternInterface $pattern) {
    $patternData = [];
    return $this->mergeData($this->globalData, $patternData);
  }

  protected function getPatternsIterator() {
    return new \RecursiveIteratorIterator($this->patternlab->getPatterns(), \RecursiveIteratorIterator::CHILD_FIRST);
  }

  protected function getTypePatterns(PatternTypeInterface $type) {
    return $this->typePatterns[$type->getId()];
  }

  protected function initializeVariables() {
    $this->navigation = new Navigation();
    $this->patterns = [];
    $this->typePatterns = [];
    $this->subtypePatterns = [];
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
    #print_r($this->files);
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

  protected function makePatternPages() {
    foreach ($this->patternlab->getTypes() as $type) {
      $typePage = new TypeIndexPage($this, $type);
      foreach ($type->getSubtypes() as $subtype) {
        $subtypePage = new SubTypeIndexPage($this, $subtype);
        foreach ($subtype->getPatterns() as $pattern) {
          $subtypePage->addPartial($pattern);
          $typePage->addPartial($pattern);
          foreach ($pattern->getPseudoPatterns() as $pseudo) {
            $subtypePage->addPartial($pseudo);
            $typePage->addPartial($pseudo);
          }
        }
        print $subtypePage;
      }
      foreach ($type->getPatterns() as $pattern) {
        $typePage->addPartial($pattern);
        foreach ($pattern->getPseudoPatterns() as $pseudo) {
          $typePage->addPartial($pseudo);
        }
      }
      print $typePage;
    }
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

  protected function addPattern(PatternInterface $pattern) {
    $this->pages[$pattern->getId()] = new PatternPage($this, $pattern);
    $this->getIndexPage()->addPattern($pattern);
    $this->getTypePage($pattern->getTypeId())->addPattern($pattern);
    if ($pattern->hasSubType()) $this->getSubtypePage($pattern->getSubTypeId())->addPattern($pattern);
    $this->navigation->addPattern($pattern);
  }

  protected function addSubtype(PatternSubTypeInterface $subtype) {
    $this->pages[$subtype->getId()] = new SubTypeIndexPage($this, $subtype);
    $this->navigation->addSubtype($subtype);
  }

  protected function addType(PatternTypeInterface $type) {
    $this->pages[$type->getId()] = new TypeIndexPage($this, $type);
    $this->navigation->addType($type);
  }

  /**
   * @return \Labcoat\Styleguide\Pages\StyleguideIndexPageInterface
   */
  protected function getIndexPage() {
    return $this->indexPage;
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




  protected function mergeData(array $old, array $new) {
    return array_merge_recursive($old, $new);
  }

  protected function renderPattern(PatternInterface $pattern, array $data) {
    $path = $pattern->getPath();
    $content = $this->patternlab->render($path, $data);
    return $content;
  }

  protected function storePatternContent(PatternInterface $pattern, $content) {
    #$this->patterns[$pattern->getId()] = $content;
    #$this->typePatterns[$pattern->getType()][] = $content;
    #if ($pattern->hasSubType()) $this->subtypePatterns[$pattern->getSubType()][] = $content;
  }

  protected function writeTypeIndex(PatternTypeInterface $type, array $patterns) {
  }




  protected function getPatternFooterTemplatePath() {
    return $this->patternlab->getMetaDirectory() . DIRECTORY_SEPARATOR . '_01-foot.twig';
  }

  protected function getPatternHeaderTemplatePath() {
    return $this->patternlab->getMetaDirectory() . DIRECTORY_SEPARATOR . '_00-head.twig';
  }

  protected function getStyleguideTemplateContent($template) {
    return file_get_contents($this->getStyleguideTemplatePath($template));
  }

  protected function getStyleguideTemplatePath($template) {
    return $this->getStyleguideTemplatesPath() . DIRECTORY_SEPARATOR . $template;
  }

  protected function getStyleguideTemplatesPath() {
    return $this->patternlab->getVendorDirectory() . '/pattern-lab/styleguidekit-twig-default/views';
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