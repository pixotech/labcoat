<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2016, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\PatternLab\Styleguide;

use Labcoat\PatternLab\PatternInterface as PatternSourceInterface;
use Labcoat\PatternLab\Styleguide\Files\Html\PageRenderer;
use Labcoat\PatternLab\Styleguide\Patterns\Pattern;
use Labcoat\PatternLab\Styleguide\Files\Html\ViewAll\ViewAllPage;
use Labcoat\PatternLab\Styleguide\Files\Javascript\AnnotationsFile;
use Labcoat\PatternLab\Styleguide\Files\Assets\AssetFile;
use Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile;
use Labcoat\PatternLab\Styleguide\Files\Text\LatestChangeFile;
use Labcoat\PatternLab\Styleguide\Files\Html\Patterns\PatternPage;
use Labcoat\PatternLab\Styleguide\Files\Html\ViewAll\ViewAllSubtypePage;
use Labcoat\PatternLab\Styleguide\Files\Html\ViewAll\ViewAllTypePage;
use Labcoat\PatternLab\Styleguide\Files\Patterns\EscapedSourceFile;
use Labcoat\PatternLab\Styleguide\Files\Patterns\SourceFile;
use Labcoat\PatternLab\Styleguide\Files\Patterns\TemplateFile;
use Labcoat\PatternLab\Styleguide\Types\Type;
use Labcoat\Generator\Files\FileInterface;
use Labcoat\Generator\Generator;
use Labcoat\PatternLabInterface;
use Labcoat\Twig\Loader;

class Styleguide implements \IteratorAggregate, StyleguideInterface {

  protected $annotationsFilePath;

  /**
   * @var int
   */
  protected $cacheBuster;

  /**
   * @var \Labcoat\Generator\Files\FileInterface[]
   */
  protected $files;

  /**
   * @var array|null
   */
  protected $globalData = [];

  /**
   * @var array
   */
  protected $hiddenControls = [];

  protected $pageRenderer;

  protected $patternFooterTemplatePath;

  protected $patternHeaderTemplatePath;

  /**
   * @var Patterns\PatternInterface[]
   */
  protected $patterns = [];

  protected $patternTemplateParser;

  /**
   * @var Types\TypeInterface[]
   */
  protected $types = [];

  public function __construct(PatternLabInterface $patternlab) {
    $this->patternTemplateParser = $this->makePatternTemplateParser($patternlab);
  }

  public function __toString() {
    $str = '';
    foreach ($this->getFiles() as $file) {
      $str .= $file->getPath() . "\n";
      $str .= '  ' . date('r', $file->getTime()) . "\n";
    }
    return $str;
  }

  public function addPattern(PatternSourceInterface $source) {
    $pattern = new Pattern($source, $this->patternTemplateParser, $this->getGlobalData());
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
    return new \ArrayIterator($this->getFiles());
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

  protected function clearFiles() {
    $this->files = null;
  }

  protected function findAssetsDirectory() {
    if (!$vendor = $this->findVendorDirectory()) return null;
    $path = implode(DIRECTORY_SEPARATOR, [$vendor, 'pattern-lab', 'styleguidekit-assets-default', 'dist']);
    return is_dir($path) ? $path : null;
  }

  protected function findVendorDirectory() {
    $className = "Composer\\Autoload\\ClassLoader";
    if (!class_exists($className)) return null;
    $c = new \ReflectionClass($className);
    return dirname($c->getFileName()) . '/..';
  }

  protected function getFiles() {
    if (!isset($this->files)) $this->makeFiles();
    return $this->files;
  }

  protected function getOrCreateType($type) {
    $key = (string)$type;
    if (!isset($this->types[$key])) $this->types[$key] = new Type($type);
    return $this->types[$key];
  }

  protected function getPageFooterContent() {
    return $this->hasCustomPageFooter() ? file_get_contents($this->patternFooterTemplatePath) : '';
  }

  protected function getPageHeaderContent() {
    return $this->hasCustomPageHeader() ? file_get_contents($this->patternHeaderTemplatePath) : '';
  }

  protected function getPageRenderer() {
    if (!isset($this->pageRenderer)) $this->pageRenderer = $this->makePageRenderer();
    return $this->pageRenderer;
  }

  protected function getPatterns() {
    return $this->patterns;
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

  protected function hasFolderIndexes() {
    return true;
  }

  protected function makeAnnotationsFile() {
    if ($path = $this->getAnnotationsFilePath()) {
      $this->addFile(new AnnotationsFile($path));
    }
  }

  protected function makeAssetFiles() {
    if (!$assetsDir = $this->findAssetsDirectory()) return;
    $dir = new \RecursiveDirectoryIterator($assetsDir, \FilesystemIterator::SKIP_DOTS);
    $files = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($files as $file => $obj) {
      $path = substr($file, strlen($assetsDir) + 1);
      $this->addFile(new AssetFile($path, $file));
    }
  }

  protected function makeDataFile() {
    $this->addFile(new DataFile($this));
  }

  protected function makeFiles() {
    $this->makePages();
    $this->makeAssetFiles();
    $this->makeDataFile();
    $this->makeAnnotationsFile();
    $this->makeLatestChangeFile();
  }

  protected function makeIndexPages() {
    /** @var Files\Html\ViewAll\ViewAllPageInterface[] $indexes */
    $indexes = ['all' => new ViewAllPage($this->getPageRenderer())];
    foreach ($this->getTypes() as $type) {
      $typeId = $type->getId();
      $indexes[$typeId] = new ViewAllTypePage($this->getPageRenderer(), $type);
      foreach ($type->getSubtypes() as $subtype) {
        $subtypeId = $subtype->getId();
        $indexes[$subtypeId] = new ViewAllSubtypePage($this->getPageRenderer(), $subtype);
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

  protected function makeLatestChangeFile() {
    $this->addFile(new LatestChangeFile(time()));
  }

  protected function makePageRenderer() {
    return new PageRenderer($this->getPageHeaderContent(), $this->getPageFooterContent());
  }

  protected function makePages() {
    $this->makePatternPages();
    if ($this->hasFolderIndexes()) $this->makeIndexPages();
  }

  protected function makePatternPages() {
    foreach ($this->getPatterns() as $pattern) {
      $this->addFile(new PatternPage($this->getPageRenderer(), $pattern));
      $this->addFile(new SourceFile($pattern));
      $this->addFile(new EscapedSourceFile($pattern));
      $this->addFile(new TemplateFile($pattern));
    }
  }

  protected function makePatternTemplateParser(PatternLabInterface $patternlab) {
    $loader = new Loader($patternlab);
    return new \Twig_Environment($loader);
  }
}