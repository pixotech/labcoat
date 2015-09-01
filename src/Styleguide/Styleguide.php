<?php

namespace Labcoat\Styleguide;

use Labcoat\PatternLab;
use Labcoat\PatternLabInterface;
use Labcoat\Patterns\Pattern;
use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PatternSubType;
use Labcoat\Patterns\PatternSubTypeInterface;
use Labcoat\Patterns\PatternType;
use Labcoat\Patterns\PatternTypeInterface;
use Labcoat\Patterns\PseudoPattern;
use Labcoat\Patterns\PseudoPatternInterface;
use Labcoat\Styleguide\Files\AnnotationsFile;
use Labcoat\Styleguide\Files\DataFile;
use Labcoat\Styleguide\Files\DynamicFileInterface;
use Labcoat\Styleguide\Files\PatternEscapedHtmlFile;
use Labcoat\Styleguide\Files\PatternHtmlFile;
use Labcoat\Styleguide\Files\PatternPageFile;
use Labcoat\Styleguide\Files\PatternTemplateFile;
use Labcoat\Styleguide\Files\StyleguideIndexFile;
use Labcoat\Styleguide\Files\SubTypeIndexFile;
use Labcoat\Styleguide\Files\TypeIndexFile;
use Labcoat\Styleguide\Navigation\Navigation;
use Labcoat\Styleguide\Navigation\Pattern as NavigationPattern;
use Labcoat\Styleguide\Pages\PatternPage;
use Labcoat\Styleguide\Pages\SubTypeIndexPage;
use Labcoat\Styleguide\Pages\TypeIndexPage;

class Styleguide implements StyleguideInterface {

  protected $cacheBuster;

  protected $data;

  protected $destinationPath;

  protected $globalData;

  protected $indexFiles;

  protected $indexPaths = [];

  /**
   * @var Navigation
   */
  protected $navigation;

  protected $patternFileSets;

  protected $patternlab;

  protected $patternPaths = [];

  protected $patterns;

  protected $subtypePatterns;

  protected $twig;

  protected $typePatterns;

  public function __construct(PatternLabInterface $patternlab, $destination) {
    $this->patternlab = $patternlab;
    $this->destinationPath = $destination;
    $this->cacheBuster = time();
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


  protected function _makePatternPages() {
    $this->initializeVariables();
    $this->loadGlobalData();

    foreach ($this->getPatternsIterator() as $item) {

      print get_class($item);
      print "\n";


      if ($item instanceof PatternInterface) {

        $patternData = $this->getPatternData($item);

        $patternContent = $this->renderPattern($item, $patternData);

        /*
        $this->storePatternContent($item, $patternContent);

        $this->addPatternPath($item);
        #$this->navigation->addPattern($item);

        foreach ($item->getPseudoPatterns() as $pseudo) {

          $pseudoData = $this->getPatternData($pseudo);

          $pseudoContent = $this->renderPattern($pseudo, $pseudoData);

          $this->storePatternContent($pseudo, $pseudoContent);

          $this->addPatternPath($pseudo);
          # $this->navigation->addPattern($item);
        }
        */
      }
      elseif ($item instanceof PatternSubTypeInterface) {

        $contents = $this->subtypePatterns[$item->getId()];

        $this->writeSubtypeIndex($item, $contents);

        $this->addSubtypeIndexPath($item);
        #$this->navigation->addSubtype($item);

        unset($this->subtypePatterns[$item->getId()]);

      }
      elseif ($item instanceof PatternTypeInterface) {

        $contents = $this->getTypePatterns($item);

        $this->writeTypeIndex($item, $contents);

        #$this->navigation->addType($item);

        unset($this->typePatterns[$item->getId()]);

      }
    }

    $this->writeIndex($patterns);

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