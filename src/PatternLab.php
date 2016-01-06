<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2015, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat;

use Labcoat\Configuration\ConfigurationInterface;
use Labcoat\Configuration\LabcoatConfiguration;
use Labcoat\Configuration\StandardEditionConfiguration;
use Labcoat\Data\Data;
use Labcoat\Data\DataInterface;
use Labcoat\PatternLab\NameInterface;
use Labcoat\PatternLab\Patterns\Path;
use Labcoat\PatternLab\Patterns\Pattern;
use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Patterns\Types\Type;
use Labcoat\Twig\Environment;

class PatternLab implements PatternLabInterface {

  /**
   * @var ConfigurationInterface
   */
  protected $config;

  /**
   * @var \Labcoat\Data\DataInterface
   */
  protected $globalData;

  /**
   * @var \Labcoat\PatternLab\Patterns\PatternInterface[]
   */
  protected $patterns;

  /**
   * @var \Labcoat\Twig\Environment
   */
  protected $twig;

  /**
   * @var \Labcoat\PatternLab\Patterns\Types\TypeInterface[]
   */
  protected $types;

  /**
   * Is this a partial name?
   *
   * Labcoat assumes that a name is a partial if it doesn't contain a slash
   *
   * @param string $name The name of the pattern
   * @return bool True if the name is a path; otherwise, false
   */
  public static function isPartialName($name) {
    return false === strpos($name, '/');
  }

  /**
   * Is this a path?
   *
   * Labcoat assumes that a name is a path if it contains a slash
   *
   * @param string $name The name of the pattern
   * @return bool True if the name is a path; otherwise, false
   */
  public static function isPathName($name) {
    return false !== strpos($name, DIRECTORY_SEPARATOR);
  }

  /**
   * Load a Pattern Lab installation that uses the default Labcoat file structure
   *
   * @param string $dir The path to the Pattern Lab installation
   * @return PatternLab A new PatternLab object
   */
  public static function load($dir) {
    $config = new LabcoatConfiguration($dir);
    return new PatternLab($config);
  }

  /**
   * Load a Pattern Lab installation that uses the Standard Edition file structure
   *
   * @param string $dir The path to the Pattern Lab installation
   * @return PatternLab A new PatternLab object
   */
  public static function loadStandardEdition($dir) {
    $config = new StandardEditionConfiguration($dir);
    return new PatternLab($config);
  }

  /**
   * Make a path string from an array of segments
   *
   * @param array $segments An array of path segments
   * @return string A path
   */
  public static function makePath(array $segments) {
    return implode('/', $segments);
  }

  /**
   * Normalize a template path
   *
   * Normalization invokes:
   * - Removing all ordering digits
   * - Replace all slashes with a forward slash
   *
   * @param string $path The raw path
   * @return string The normalized path
   */
  public static function normalizePath($path) {
    return (string)(new Path($path))->normalize();
  }


  /**
   * Constructor
   *
   * @param \Labcoat\Configuration\ConfigurationInterface $config A configuration object
   */
  public function __construct(ConfigurationInterface $config) {
    $this->config = $config;
    $this->loadGlobalData();
    $this->findPatterns();
    $this->makeParser();
  }

  public function __toString() {
    $str = '';
    foreach ($this->getPatterns() as $pattern) {
      $str .= $pattern->getFile() . "\n";
      $str .= '  Type: ' . $pattern->getType() . "\n";
      $str .= '  Subtype: ' . ($pattern->hasSubtype() ? $pattern->getSubtype() : '') . "\n";
      $str .= '  Partial: ' . $pattern->getPartial() . "\n";
    }
    return $str;
  }

  /**
   * {@inheritdoc}
   */
  public function getAnnotationsFile() {
    return $this->config->getAnnotationsFile();
  }

  /**
   * {@inheritdoc}
   */
  public function getGlobalData() {
    return $this->globalData;
  }

  /**
   * {@inheritdoc}
   */
  public function getHiddenControls() {
    return $this->config->getHiddenControls();
  }

  /**
   * {@inheritdoc}
   */
  public function getPatternExtension() {
    return $this->config->getPatternExtension();
  }

  /**
   * {@inheritdoc}
   */
  public function getPatterns() {
    return $this->patterns;
  }

  /**
   * {@inheritdoc}
   */
  public function getPatternsDirectory() {
    return $this->config->getPatternsDirectory();
  }

  public function getPatternsThatInclude(PatternInterface $pattern) {
    $patterns = [];
    foreach ($this->getPatterns() as $other) {
      if ($other->includes($pattern)) $patterns[] = $pattern;
    }
    return $patterns;
  }

  /**
   * {@inheritdoc}
   */
  public function getStyleguideFooter() {
    return $this->config->getStyleguideFooter();
  }

  /**
   * {@inheritdoc}
   */
  public function getStyleguideHeader() {
    return $this->config->getStyleguideHeader();
  }

  /**
   * @return \Labcoat\PatternLab\Patterns\Types\TypeInterface[]
   */
  public function getTypes() {
    return $this->types;
  }

  public function hasStyleguideFooter() {
    return $this->config->hasStyleguideFooter();
  }

  public function hasStyleguideHeader() {
    return $this->config->hasStyleguideHeader();
  }


  public function render(PatternInterface $pattern, DataInterface $data = null) {
    return $this->twig->render($pattern->getPath(), isset($data) ? $data->toArray() : []);
  }

  /**
   * Look in the pattern directory for pattern templates
   */
  protected function findPatterns() {
    $dir = $this->getPatternsDirectory();
    $ext = $this->getPatternExtension();
    foreach ($this->getPatternFilesIterator() as $match => $file) {
      $path = substr($match, strlen($dir) + 1, -1 - strlen($ext));
      $pattern = new Pattern($this, $path, $match);
      $this->patterns[] = $pattern;
      if ($pattern->hasType()) $this->getOrCreateType($pattern->getType())->addPattern($pattern);
    }
  }

  /**
   * Look for a type with the provided path, and create it if it doesn't exist
   *
   * @param string $name The name of the type
   * @return \Labcoat\PatternLab\Patterns\Types\TypeInterface A pattern type object
   */
  protected function getOrCreateType(NameInterface $name) {
    $key = (string)$name;
    if (!isset($this->types[$key])) $this->types[$key] = new Type($name);
    return $this->types[$key];
  }

  protected function getPatternFilesIterator() {
    $dir = $this->getPatternsDirectory();
    $ext = $this->getPatternExtension();
    $flags = \FilesystemIterator::SKIP_DOTS;
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, $flags));
    $regex = '|\.' . preg_quote($ext) . '$|';
    return new \RegexIterator($files, $regex, \RegexIterator::MATCH);
  }

  /**
   * Load all global pattern data
   */
  protected function loadGlobalData() {
    $this->globalData = new Data();
    foreach ($this->config->getGlobalDataFiles() as $path) {
      $this->globalData->merge(Data::load($path));
    }
  }

  protected function makeParser() {
    $this->twig = new Environment($this);
  }

  /**
   * Remove the template extension from a path
   *
   * @param string $path The template path with extension
   * @return string The path with the extension removed
   */
  protected function stripPatternExtensionFromPath($path) {
    $ext = '.' . $this->getPatternExtension();
    if (substr($path, 0 - strlen($ext)) == $ext) $path = substr($path, 0, 0 - strlen($ext));
    return $path;
  }
}
