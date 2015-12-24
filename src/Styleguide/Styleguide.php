<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2015, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\Styleguide;

use Labcoat\PatternLab;
use Labcoat\PatternLabInterface;
use Labcoat\Styleguide\Files\Html\ViewAll\ViewAllPage;
use Labcoat\Styleguide\Files\Javascript\AnnotationsFile;
use Labcoat\Styleguide\Files\Assets\AssetFile;
use Labcoat\Styleguide\Files\Javascript\DataFile;
use Labcoat\Generator\Files\FileInterface;
use Labcoat\Styleguide\Files\LatestChangeFile;
use Labcoat\Styleguide\Files\Html\Patterns\PatternPage;
use Labcoat\Styleguide\Files\Html\ViewAll\ViewAllSubtypePage;
use Labcoat\Styleguide\Files\Html\ViewAll\ViewAllTypePage;
use Labcoat\Styleguide\Files\Patterns\EscapedSourceFile;
use Labcoat\Styleguide\Files\Patterns\SourceFile;
use Labcoat\Styleguide\Files\Patterns\TemplateFile;
use Labcoat\Generator\Generator;

class Styleguide implements \IteratorAggregate, StyleguideInterface {

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
  protected $globalData;

  /**
   * @var \Labcoat\PatternLabInterface
   */
  protected $patternlab;

  /**
   * @var \Twig_Environment
   */
  protected $templateParser;

  /**
   * @param PatternLabInterface $patternlab
   */
  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
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

  /**
   * {@inheritdoc}
   */
  public function generate($directory) {
    $generator = new Generator($this, $directory);
    return $generator->__invoke();
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
    if (!isset($this->globalData)) $this->globalData = $this->patternlab->getGlobalData();
    return $this->globalData;
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
   * {@inheritdoc}
   */
  public function getPatternLab() {
    return $this->patternlab;
  }

  /**
   * {@inheritdoc}
   */
  public function render($template, array $data = []) {
    return $this->getTemplateParser()->render($template, $data);
  }

  /**
   * Add a file to the style guide
   *
   * @param FileInterface $file A file object
   */
  protected function addFile(FileInterface $file) {
    $this->files[$file->getPath()] = $file;
  }

  protected function findAssetsDirectory() {
    if (!$vendor = $this->findVendorDirectory()) return null;
    $path = PatternLab::makePath([$vendor, 'pattern-lab', 'styleguidekit-assets-default', 'dist']);
    return is_dir($path) ? $path : null;
  }

  protected function findTemplatesDirectory() {
    if (!$vendor = $this->findVendorDirectory()) return null;
    $path = PatternLab::makePath([$vendor, 'pattern-lab', 'styleguidekit-twig-default', 'views']);
    return is_dir($path) ? $path : null;
  }

  protected function findVendorDirectory() {
    $className = "Composer\\Autoload\\ClassLoader";
    if (!class_exists($className)) return null;
    $c = new \ReflectionClass($className);
    return dirname($c->getFileName()) . '/..';
  }

  /**
   * Get the path to the style guide footer template
   *
   * @return string The template path
   */
  protected function getPatternFooterTemplatePath() {
    return $this->patternlab->getStyleguideFooter();
  }

  /**
   * Get the path to the style guide header template
   *
   * @return string The template path
   */
  protected function getPatternHeaderTemplatePath() {
    return $this->patternlab->getStyleguideHeader();
  }

  /**
   * Get the Twig parser for style guide templates
   *
   * @return \Twig_Environment A Twig parser object
   */
  protected function getTemplateParser() {
    if (!isset($this->templateParser)) $this->templateParser = $this->makeDocumentTemplateParser();
    return $this->templateParser;
  }

  protected function hasFolderIndexes() {
    return true;
  }

  /**
   * Make the annotations file object
   */
  protected function makeAnnotationsFile() {
    if ($path = $this->patternlab->getAnnotationsFile()) {
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
    $this->addFile(new DataFile($this->patternlab));
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
    $this->addFile(new ViewAllPage($this));
    foreach ($this->patternlab->getTypes() as $type) {
      $this->addFile(new ViewAllTypePage($this, $type));
      foreach ($type->getSubtypes() as $subtype) {
        $this->addFile(new ViewAllSubtypePage($this, $subtype));
      }
    }
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
    foreach ($this->patternlab->getPatterns() as $pattern) {
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

  protected function makeDocument($content, array $vars = []) {

  }

  protected function hasCustomDocumentFooter() {
    return $this->getPatternLab()->hasStyleguideFooter();
  }

  protected function hasCustomDocumentHeader() {
    return $this->getPatternLab()->hasStyleguideHeader();
  }

  protected function hasCustomDocumentTemplates() {
    return $this->hasCustomDocumentHeader() and $this->hasCustomDocumentFooter();
  }

  protected function makeDocumentTemplateParser() {
    if (!$this->hasCustomDocumentTemplates()) throw new \BadMethodCallException();
    $loader = new \Twig_Loader_Array([
      'patternLabHead' => file_get_contents($this->getPatternLab()->getStyleguideHeader()),
      'patternLabFoot' => file_get_contents($this->getPatternLab()->getStyleguideFooter()),
    ]);
    return new \Twig_Environment($loader, ['cache' => false]);
  }
}