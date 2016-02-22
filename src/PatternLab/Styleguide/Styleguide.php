<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2016, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\PatternLab\Styleguide;

use Labcoat\PatternLab\PatternInterface as PatternSourceInterface;
use Labcoat\PatternLab\Styleguide\Patterns\Pattern;
use Labcoat\PatternLab\Styleguide\Twig\HeaderFooterTemplateLoader;
use Labcoat\PatternLab\Styleguide\Twig\StyleguideTemplateLoader;
use Labcoat\PatternLab\Styleguide\Files\Html\ViewAll\ViewAllPage;
use Labcoat\PatternLab\Styleguide\Files\Javascript\AnnotationsFile;
use Labcoat\PatternLab\Styleguide\Files\Assets\AssetFile;
use Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile;
use Labcoat\PatternLab\Styleguide\Files\Text\LatestChangeFile;
use Labcoat\PatternLab\Styleguide\Files\Html\PageInterface;
use Labcoat\PatternLab\Styleguide\Files\Html\Patterns\PatternPage;
use Labcoat\PatternLab\Styleguide\Files\Html\ViewAll\ViewAllSubtypePage;
use Labcoat\PatternLab\Styleguide\Files\Html\ViewAll\ViewAllTypePage;
use Labcoat\PatternLab\Styleguide\Files\Patterns\EscapedSourceFile;
use Labcoat\PatternLab\Styleguide\Files\Patterns\SourceFile;
use Labcoat\PatternLab\Styleguide\Files\Patterns\TemplateFile;
use Labcoat\PatternLab\Styleguide\Types\Type;
use Labcoat\Generator\Files\FileInterface;
use Labcoat\Generator\Generator;

class Styleguide implements \IteratorAggregate, StyleguideInterface {

  protected $annotationsFilePath;

  /**
   * @var int
   */
  protected $cacheBuster;

  /**
   * @var \Labcoat\Generator\Files\FileInterface[]
   */
  protected $files = [];

  /**
   * @var array|null
   */
  protected $globalData = [];

  /**
   * @var array
   */
  protected $hiddenControls = [];

  /**
   * A separate Twig parser for custom page header & footer templates
   *
   * @var \Twig_Environment
   */
  protected $pageTemplateParser;

  protected $patternFooterTemplatePath;

  protected $patternHeaderTemplatePath;

  /**
   * @var Patterns\PatternInterface[]
   */
  protected $patterns = [];

  /**
   * @var \Twig_Environment
   */
  protected $templateParser;

  /**
   * @var Types\TypeInterface[]
   */
  protected $types = [];

  public function __construct() {
    $this->makeCacheBuster();
    $this->makeFiles();
  }

  public function __toString() {
    $str = '';
    foreach ($this->files as $file) {
      $str .= $file->getPath() . "\n";
      $str .= '  ' . date('r', $file->getTime()) . "\n";
    }
    return $str;
  }

  public function addPattern(PatternSourceInterface $source) {
    $pattern = new Pattern($source);
    $this->patterns[] = $pattern;
    if ($pattern->hasType()) $this->getOrCreateType($pattern->getType())->addPattern($pattern);
  }

  /**
   * {@inheritdoc}
   */
  public function generate($directory) {
    $generator = new Generator($this, $directory);
    return $generator->__invoke();
  }

  /**
   * @return mixed
   */
  public function getAnnotationsFilePath() {
    return $this->annotationsFilePath;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheBuster() {
    return $this->cacheBuster;
  }

  /**
   * {@inheritdoc}
   */
  public function getGlobalData() {
    return $this->globalData;
  }

  /**
   * @return array
   */
  public function getHiddenControls() {
    return $this->hiddenControls;
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator() {
    return new \ArrayIterator($this->files);
  }

  /**
   * {@inheritdoc}
   */
  public function getMaximumWidth() {
    return '2600';
  }

  /**
   * {@inheritdoc}
   */
  public function getMinimumWidth() {
    return '240';
  }

  /**
   * Get the path to the style guide footer template
   *
   * @return string The template path
   */
  public function getPatternFooterTemplatePath() {
    return $this->patternFooterTemplatePath;
  }

  /**
   * Get the path to the style guide header template
   *
   * @return string The template path
   */
  public function getPatternHeaderTemplatePath() {
    return $this->patternHeaderTemplatePath;
  }

  /**
   * @return Types\TypeInterface[]
   */
  public function getTypes() {
    return $this->types;
  }

  /**
   * {@inheritdoc}
   */
  public function render($template, array $data = []) {
    return $this->getTemplateParser()->render($template, $data);
  }

  /**
   * @param string $path
   */
  public function setAnnotationsFilePath($path) {
    $this->annotationsFilePath = $path;
  }

  /**
   * @param array|null $data
   */
  public function setGlobalData($data) {
    $this->globalData = $data;
  }

  /**
   * @param array $hiddenControls
   */
  public function setHiddenControls(array $hiddenControls) {
    $this->hiddenControls = $hiddenControls;
  }

  /**
   * @param string $path
   */
  public function setPatternFooterTemplatePath($path) {
    $this->patternFooterTemplatePath = $path;
  }

  /**
   * @param string $path
   */
  public function setPatternHeaderTemplatePath($path) {
    $this->patternHeaderTemplatePath = $path;
  }

  /**
   * Add a file to the style guide
   *
   * @param FileInterface $file A file object
   */
  protected function addFile(FileInterface $file) {
    $this->files[(string)$file->getPath()] = $file;
  }

  protected function findAssetsDirectory() {
    if (!$vendor = $this->findVendorDirectory()) return null;
    $path = implode(DIRECTORY_SEPARATOR, [$vendor, 'pattern-lab', 'styleguidekit-assets-default', 'dist']);
    return is_dir($path) ? $path : null;
  }

  protected function findTemplatesDirectory() {
    if (!$vendor = $this->findVendorDirectory()) return null;
    $path = implode(DIRECTORY_SEPARATOR, [$vendor, 'pattern-lab', 'styleguidekit-twig-default', 'views']);
    return is_dir($path) ? $path : null;
  }

  protected function findVendorDirectory() {
    $className = "Composer\\Autoload\\ClassLoader";
    if (!class_exists($className)) return null;
    $c = new \ReflectionClass($className);
    return dirname($c->getFileName()) . '/..';
  }

  protected function getOrCreateType($type) {
    if (!isset($this->types[$type])) $this->types[$type] = new Type($type);
    return $this->types[$type];
  }

  protected function getPatterns() {
    return $this->patterns;
  }

  /**
   * Get the Twig parser for style guide templates
   *
   * @return \Twig_Environment A Twig parser object
   */
  protected function getTemplateParser() {
    if (!isset($this->templateParser)) $this->templateParser = $this->makeTemplateParser();
    return $this->templateParser;
  }

  protected function hasFolderIndexes() {
    return true;
  }

  /**
   * Make the annotations file object
   */
  protected function makeAnnotationsFile() {
    if ($path = $this->getAnnotationsFilePath()) {
      $this->addFile(new AnnotationsFile($path));
    }
  }

  /**
   */
  protected function makeCacheBuster() {
    $this->cacheBuster = time();
  }

  /**
   * Make the Pattern Lab data file object
   */
  protected function makeDataFile() {
    $this->addFile(new DataFile($this));
  }

  /**
   * Make all file objects
   */
  protected function makeFiles() {
    $this->makePages();
    $this->makeAssetFiles();
    $this->makeDataFile();
    $this->makeAnnotationsFile();
    $this->makeLatestChangeFile();
  }

  protected function makeIndexPages() {
    /** @var Files\Html\ViewAll\ViewAllPageInterface[] $indexes */
    $indexes = ['all' => new ViewAllPage($this)];
    foreach ($this->getTypes() as $type) {
      $typeId = $type->getId();
      $indexes[$typeId] = new ViewAllTypePage($this, $type);
      foreach ($type->getSubtypes() as $subtype) {
        $subtypeId = $subtype->getId();
        $indexes[$subtypeId] = new ViewAllSubtypePage($this, $subtype);
        foreach ($subtype->getPatterns() as $pattern) {
          $indexes['all']->addPattern($pattern);
          $indexes[$typeId]->addPattern($pattern);
          $indexes[$subtypeId]->addPattern($pattern);
        }
      }
      foreach ($type->getPatterns() as $pattern) {
        $indexes['all']->addPattern($pattern);
        $indexes[$typeId]->addPattern($pattern);
      }
    }
    foreach ($indexes as $index) $this->addFile($index);
  }

  /**
   * Make the latest change file object
   */
  protected function makeLatestChangeFile() {
    $this->addFile(new LatestChangeFile(time()));
  }

  /**
   * Make file objects for all the style guide pages
   */
  protected function makePages() {
    $this->makePatternPages();
    if ($this->hasFolderIndexes()) $this->makeIndexPages();
  }

  protected function makePatternPages() {
    foreach ($this->getPatterns() as $pattern) {
      $this->addFile(new PatternPage($this, $pattern));
      $this->addFile(new SourceFile($pattern));
      $this->addFile(new EscapedSourceFile($pattern));
      $this->addFile(new TemplateFile($pattern));
    }
  }

  /**
   * Make all style guide asset file objects
   */
  protected function makeAssetFiles() {
    if (!$assetsDir = $this->findAssetsDirectory()) return;
    $dir = new \RecursiveDirectoryIterator($assetsDir, \FilesystemIterator::SKIP_DOTS);
    $files = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($files as $file => $obj) {
      $path = substr($file, strlen($assetsDir) + 1);
      $this->addFile(new AssetFile($path, $file));
    }
  }



  # Page rendering

  public function renderPage(PageInterface $page) {
    if ($this->hasCustomPageTemplates()) return $this->renderPageWithCustomTemplates($page);
    return null;
  }

  protected function getPageFooterVariables(PageInterface $page) {
    $vars = [
      'cacheBuster' => $this->getCacheBuster(),
      'patternLabFoot' => $this->getPatternLabFooterContent($page),
    ];
    return $vars + $page->getVariables();
  }

  protected function getPageHeaderVariables(PageInterface $page) {
    $vars = [
      'cacheBuster' => $this->getCacheBuster(),
      'patternLabHead' => $this->getPatternLabHeaderContent(),
    ];
    return $vars + $page->getVariables();
  }

  protected function getPageTemplateParser() {
    if (!isset($this->pageTemplateParser)) $this->pageTemplateParser = $this->makePageTemplateParser();
    return $this->pageTemplateParser;
  }

  protected function getPatternLabFooterContent(PageInterface $page) {
    $vars = [
      'cacheBuster' => $this->getCacheBuster(),
      'patternData' => json_encode($page->getData()),
    ];
    return $this->render('partials/general-footer', $vars);
  }

  protected function getPatternLabHeaderContent() {
    $vars = [
      'cacheBuster' => $this->getCacheBuster(),
    ];
    return $this->render('partials/general-header', $vars);
  }

  protected function hasCustomPageFooter() {
    return !empty($this->patternFooterTemplatePath);
  }

  protected function hasCustomPageHeader() {
    return !empty($this->patternHeaderTemplatePath);
  }

  protected function hasCustomPageTemplates() {
    return $this->hasCustomPageHeader() and $this->hasCustomPageFooter();
  }

  protected function makeCustomPageFooter(PageInterface $page) {
    return $this->getPageTemplateParser()->render('footer', $this->getPageFooterVariables($page));
  }

  protected function makeCustomPageHeader(PageInterface $page) {
    return $this->getPageTemplateParser()->render('header', $this->getPageHeaderVariables($page));
  }

  protected function makePageTemplateParser() {
    if (!$this->hasCustomPageTemplates()) throw new \BadMethodCallException();
    $loader = new HeaderFooterTemplateLoader($this->getPatternLab());
    return new \Twig_Environment($loader, ['cache' => false]);
  }

  protected function makeTemplateParser() {
    if (!$this->hasCustomPageTemplates()) throw new \BadMethodCallException();
    $loader = new StyleguideTemplateLoader();
    return new \Twig_Environment($loader, ['cache' => false]);
  }

  protected function renderPageWithCustomTemplates(PageInterface $page) {
    return $this->makeCustomPageHeader($page) . $page->getContent() . $this->makeCustomPageFooter($page);
  }
}