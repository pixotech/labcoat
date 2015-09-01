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

class Styleguide implements StyleguideInterface {

  protected $cacheBuster;

  protected $data;

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

  protected $twig;

  public function __construct(PatternLabInterface $patternlab) {
    #$this->patternlab = $patternlab;
    $this->cacheBuster = time();
    $this->makeFiles($patternlab);
  }

  public function generate() {
    $this->writePatternPages();
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

  public function renderPattern(PatternInterface $pattern) {
    $template = $pattern->getTemplate();
    $data = array_merge_recursive($this->getPatternLab()->getData(), $pattern->getData());
    return $this->getPatternLab()->render($template, $data);
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

  protected function makeFiles(PatternLabInterface $patternlab) {

    $this->patterns = [];
    $this->typePatterns = [];
    $this->subtypePatterns = [];

    $globalData = $this->getGlobalData();

    $this->navigation = new Navigation();
    $iterator = new \RecursiveIteratorIterator($patternlab->getPatterns(), \RecursiveIteratorIterator::SELF_FIRST);
    foreach ($iterator as $item) {
      if ($item instanceof PatternInterface) {

        $patternData = $globalData->import($item->getData());

        $patternContent = $this->renderPattern($item, $patternData);

        $this->patterns[$item->getId()] = $patternContent;
        $this->typePatterns[$item->getType()][] = $patternContent;
        if ($item->hasSubType()) $this->subtypePatterns[$item->getSubType()][] = $patternContent;

        $this->addPatternPath($item);
        $this->navigation->addPattern($item);
        foreach ($item->getPseudoPatterns() as $pseudo) {

          $pseudoData = $patternData->import($pseudo->getData());

          $pseudoContent = $this->renderPattern($pseudo, $pseudoData);

          $this->addPatternPath($pseudo);
          # $this->navigation->addPattern($item);
        }
      }
      elseif ($item instanceof PatternSubTypeInterface) {

        $contents = $this->subtypePatterns[$item->getId()];

        $this->writeSubtypeIndex($item, $contents);

        $this->addSubtypeIndexPath($item);
        $this->navigation->addSubtype($item);

        unset($this->subtypePatterns[$item->getId()]);

      }
      elseif ($item instanceof PatternTypeInterface) {

        $contents = $this->typePatterns[$item->getId()];

        $this->writeTypeIndex($item, $contents);

        $this->navigation->addType($item);

        unset($this->typePatterns[$item->getId()]);

      }
    }

    $this->writeIndex($patterns);

  }

  protected function ensureDirectory($path) {
    if (!is_dir($path)) mkdir($path, $this->patternlab->getDefaultDirectoryPermissions(), true);
  }

  protected function ensurePathDirectory($path) {
    $this->ensureDirectory(dirname($path));
  }

  protected function makePatternFiles(PatternInterface $pattern) {
    $files = [];
    $files[] = new PatternTemplateFile($this, $pattern);
    $files[] = new PatternHtmlFile($this, $pattern);
    $files[] = new PatternEscapedHtmlFile($this, $pattern);
    $files[] = new PatternPageFile($this, $pattern);
    return $files;
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

  protected function writePatternPages() {
    $patterns = [];
    foreach ($this->navigation->getTypes() as $type) {
      $typePatterns = [];
      foreach ($type->getSubtypes() as $subtype) {
        $subtypePatterns = [];
        foreach ($subtype->getPatterns() as $pattern) {
          $this->writePatternPage($pattern);
          $subtypePatterns[] = $pattern;
          $typePatterns[] = $pattern;
          $patterns[] = $pattern;
        }
        $this->writeSubtypePage($subtype, $subtypePatterns);
      }
      foreach ($type->getPatterns() as $pattern) {
        $this->writePatternPage($pattern);
        $typePatterns[] = $pattern;
        $patterns[] = $pattern;
      }
      $this->writeTypePage($type, $typePatterns);
    }
    $this->writeIndexPage($patterns);
  }

  protected function makeIndexPage() {

  }

  protected function makePatternPage() {

  }

  protected function makePageHeader(array $data) {

  }

  protected function makePageFooter(array $data) {

  }
}