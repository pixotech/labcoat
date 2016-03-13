<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2016, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\PatternLab\Styleguide;

use Labcoat\Html\Document;
use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\Files\Html\ViewAll\ViewAllPage;
use Labcoat\PatternLab\Styleguide\Files\Javascript\AnnotationsFile;
use Labcoat\PatternLab\Styleguide\Files\Assets\AssetFile;
use Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\DataFile;
use Labcoat\PatternLab\Styleguide\Files\Text\LatestChangeFile;
use Labcoat\PatternLab\Styleguide\Files\Html\Patterns\PatternPage;
use Labcoat\PatternLab\Styleguide\Files\Html\ViewAll\ViewAllSubtypePage;
use Labcoat\PatternLab\Styleguide\Files\Html\ViewAll\ViewAllTypePage;
use Labcoat\PatternLab\Styleguide\Files\Patterns\EscapedSourceFile;
use Labcoat\PatternLab\Styleguide\Files\Patterns\SourceFile;
use Labcoat\PatternLab\Styleguide\Files\Patterns\TemplateFile;
use Labcoat\PatternLab\Styleguide\Types\Type;
use Labcoat\Generator\Files\FileInterface;

class Styleguide implements \IteratorAggregate, StyleguideInterface {

  /**
   * @var array
   */
  protected $annotations = [];

  /**
   * @var array
   */
  protected $breakpoints = [];

  /**
   * @var string
   */
  protected $cacheBuster;

  /**
   * @var \Labcoat\Generator\Files\FileInterface[]
   */
  protected $files;

  /**
   * @var array
   */
  protected $hiddenControls = ['hay'];

  protected $maximumWidth = 2600;

  protected $minimumWidth = 240;

  protected $templateParser;

  /**
   * @var PatternInterface[]
   */
  protected $patterns = [];

  /**
   * @var array
   */
  protected $scripts = [];

  /**
   * @var array
   */
  protected $stylesheets = [];

  /**
   * @var Types\TypeInterface[]
   */
  protected $types = [];

  public function __toString() {
    $str = '';
    foreach ($this->getFiles() as $file) {
      $str .= $file->getPath() . "\n";
      $str .= '  ' . date('r', $file->getTime()) . "\n";
    }
    return $str;
  }

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
    $this->getOrCreateType($pattern->getType())->addPattern($pattern);
  }

  public function addScript($script) {
    $this->scripts[] = $script;
  }

  public function addStylesheet($stylesheet) {
    $this->stylesheets[] = $stylesheet;
  }

  public function getBreakpoints() {
    return $this->breakpoints;
  }

  /**
   * @return array
   */
  public function getAnnotations() {
    return $this->annotations;
  }

  public function getCacheBuster() {
    if (!isset($this->cacheBuster)) $this->cacheBuster = (string)time();
    return $this->cacheBuster;
  }

  public function getHiddenControls() {
    return $this->hiddenControls;
  }

  public function getIterator() {
    return new \ArrayIterator($this->getFiles());
  }

  public function getMaximumWidth() {
    return $this->maximumWidth;
  }

  public function getMinimumWidth() {
    return $this->minimumWidth;
  }

  /**
   * @return array
   */
  public function getScripts() {
    return $this->scripts;
  }

  /**
   * @return array
   */
  public function getStylesheets() {
    return $this->stylesheets;
  }

  /**
   * @return Types\TypeInterface[]
   */
  public function getTypes() {
    return $this->types;
  }

  /**
   * @param array $breakpoints
   */
  public function setBreakpoints($breakpoints) {
    $this->breakpoints = $breakpoints;
  }

  /**
   * @param string $string
   */
  public function setCacheBuster($string) {
    $this->cacheBuster = $string;
  }

  /**
   * @param array $hiddenControls
   */
  public function setHiddenControls(array $hiddenControls) {
    $this->hiddenControls = $hiddenControls;
  }

  /**
   * @param int $maximumWidth
   */
  public function setMaximumWidth($maximumWidth) {
    $this->maximumWidth = $maximumWidth;
  }

  /**
   * @param int $minimumWidth
   */
  public function setMinimumWidth($minimumWidth) {
    $this->minimumWidth = $minimumWidth;
  }

  protected function addFile(FileInterface $file) {
    $this->files[(string)$file->getPath()] = $file;
  }

  protected function addStyleguidePattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
    $this->getOrCreateType($pattern->getType())->addPattern($pattern);
  }

  protected function clearFiles() {
    $this->files = null;
  }

  protected function findAssetsDirectory() {
    if (!$vendor = $this->findVendorDirectory()) return null;
    $path = implode(DIRECTORY_SEPARATOR, [$vendor, 'pattern-lab', 'styleguidekit-assets-default', 'dist']);
    return is_dir($path) ? $path : null;
  }

  protected function findStyleguideTemplatesDirectory() {
    if (!$vendor = $this->findVendorDirectory()) return null;
    $path = $this->makePath([$vendor, 'pattern-lab', 'styleguidekit-twig-default', 'views']);
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
    if (!isset($this->types[$type])) $this->types[$type] = new Type($type);
    return $this->types[$type];
  }

  protected function getPatterns() {
    return $this->patterns;
  }

  protected function getTemplate($path) {
    $segments = explode('/', $path);
    array_unshift($this->findStyleguideTemplatesDirectory(), $segments);
    return file_get_contents($this->makePath($segments));
  }

  protected function getTemplateParser() {
    if (!isset($this->templateParser)) $this->templateParser = $this->makeTemplateParser();
    return $this->templateParser;
  }

  protected function makeAnnotationsFile() {
    $this->addFile(new AnnotationsFile($this->annotations));
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

  protected function makeDocument($content, array $data = []) {
    $content .= $this->makeGeneralFooter($data);
    $document = new Document($content, 'Pattern Lab');
    $document->setPatternLabHead($this->makeGeneralHeader());
    foreach ($this->stylesheets as $stylesheet) $document->includeStylesheet($stylesheet);
    foreach ($this->scripts as $script) $document->includeScript($script);
    return (string)$document;
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
      $typeId = $type->getName();
      $indexes[$typeId] = new ViewAllTypePage($this->getPageRenderer(), $type);
      foreach ($type->getSubtypes() as $subtype) {
        $subtypeId = $subtype->getName();
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

  protected function makePages() {
    $this->makePatternPages();
    $this->makeIndexPages();
  }

  protected function makePath(array $segments) {
    return implode(DIRECTORY_SEPARATOR, $segments);
  }

  protected function makePatternPages() {
    foreach ($this->getPatterns() as $pattern) {
      $this->addFile(new PatternPage($this->getPageRenderer(), $pattern));
      $this->addFile(new SourceFile($pattern));
      $this->addFile(new EscapedSourceFile($pattern));
      $this->addFile(new TemplateFile($pattern));
    }
  }

  protected function makeTemplateParser() {
    $templates = [
      'partials/general-footer' => $this->getTemplate('partials/general-footer.twig'),
      'partials/general-header' => $this->getTemplate('partials/general-header.twig'),
      'patternSection.twig' => $this->getTemplate('partials/patternSection.twig'),
      'patternSectionSubtype.twig' => $this->getTemplate('partials/patternSectionSubtype.twig'),
      'viewall' => $this->getTemplate('viewall.twig'),
    ];
    $loader = new \Twig_Loader_Array($templates);
    return new \Twig_Environment($loader);
  }

  protected function renderPatterns(array $patterns) {
    $vars = ['partials' => $patterns, 'patternPartial' => ''];
    return $this->getTemplateParser()->render('viewall', $vars);
  }

  /**
   * @param array $data
   * @return string
   */
  protected function makeGeneralFooter(array $data) {
    $vars = ['cacheBuster' => $this->cacheBuster, 'patternData' => json_encode($data)];
    return $this->getTemplateParser()->render('partials/general-footer', $vars);
  }

  /**
   * @return string
   */
  protected function makeGeneralHeader() {
    $vars = ['cacheBuster' => $this->cacheBuster];
    return $this->getTemplateParser()->render('partials/general-header', $vars);
  }
}