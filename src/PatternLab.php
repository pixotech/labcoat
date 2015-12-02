<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2015, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat;

use Labcoat\Assets\AssetDirectory;
use Labcoat\Configuration\ConfigurationInterface;
use Labcoat\Configuration\LabcoatConfiguration;
use Labcoat\Configuration\StandardEditionConfiguration;
use Labcoat\Patterns\Paths\SegmentInterface;
use Labcoat\Patterns\Pattern;
use Labcoat\Structure\Type;

class PatternLab implements PatternLabInterface {

  /**
   * @var \Labcoat\Assets\Asset[]
   */
  protected $assets;

  /**
   * @var ConfigurationInterface
   */
  protected $config;

  /**
   * @var array|null
   */
  protected $globalData;

  /**
   * @var \Labcoat\Patterns\PatternInterface[]
   */
  protected $patterns;

  /**
   * @var \Labcoat\Structure\TypeInterface[]
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
   * Return the contents of a json-encoded data file
   *
   * @param string $path The path to the data fle
   * @return mixed The parsed content of the file
   */
  public static function loadData($path) {
    return json_decode(file_get_contents($path), true);
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
    return implode('/', array_map(['Labcoat\Paths\Path', 'stripDigits'], explode(DIRECTORY_SEPARATOR, $path)));
  }


  /**
   * Constructor
   *
   * @param \Labcoat\Configuration\ConfigurationInterface $config A configuration object
   */
  public function __construct(ConfigurationInterface $config) {
    $this->config = $config;
    $this->findPatterns();
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
  public function getAssets() {
    if (!isset($this->assets)) $this->findAssets();
    return $this->assets;
  }

  /**
   * {@inheritdoc}
   */
  public function getGlobalData() {
    if (!isset($this->globalData)) $this->loadGlobalData();
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
  public function getIgnoredDirectories() {
    return $this->config->getIgnoredDirectories();
  }

  /**
   * {@inheritdoc}
   */
  public function getIgnoredExtensions() {
    return $this->config->getIgnoredExtensions();
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

  /**
   * {@inheritdoc}
   */
  public function getStyleguideAssetDirectories() {
    return $this->config->getStyleguideAssetDirectories();
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
   * {@inheritdoc}
   */
  public function getStyleguideTemplatesDirectory() {
    return $this->config->getStyleguideTemplatesDirectories();
  }

  /**
   * @return Structure\TypeInterface[]
   */
  public function getTypes() {
    return $this->types;
  }


  /**
   * {@inheritdoc}
   */
  public function hasIgnoredExtension($path) {
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    return in_array($ext, $this->getIgnoredExtensions());
  }

  /**
   * {@inheritdoc}
   */
  public function isHiddenFile($path) {
    return false !== strpos(DIRECTORY_SEPARATOR . $path, DIRECTORY_SEPARATOR . '_');
  }

  /**
   * {@inheritdoc}
   */
  public function isIgnoredFile($path) {
    return $this->hasIgnoredExtension($path) || $this->isInIgnoredDirectory($path);
  }

  /**
   * {@inheritdoc}
   */
  public function isInIgnoredDirectory($path) {
    $dirs = explode(DIRECTORY_SEPARATOR, dirname($path));
    return count(array_intersect($dirs, $this->getIgnoredDirectories())) > 0;
  }

  /**
   * Look in the asset directories for asset files
   */
  protected function findAssets() {
    $this->assets = [];
    foreach ($this->config->getAssetDirectories() as $dir) {
      $dir = new AssetDirectory($this, $dir);
      $this->assets += $dir->getAssets();
    }
  }

  /**
   * Look in the pattern directory for pattern templates
   */
  protected function findPatterns() {
    $dir = $this->getPatternsDirectory();
    $ext = $this->getPatternExtension();
    foreach ($this->getPatternFilesIterator() as $match => $file) {
      $path = substr($match, strlen($dir) + 1, -1 - strlen($ext));
      $pattern = new Pattern($path, $match);
      $this->patterns[] = $pattern;
      if ($pattern->hasType()) $this->getOrCreateType($pattern->getType())->addPattern($pattern);
    }
  }

  /**
   * Look for a type with the provided path, and create it if it doesn't exist
   *
   * @param SegmentInterface $name The name of the type
   * @return \Labcoat\Structure\TypeInterface A pattern type object
   */
  protected function getOrCreateType(SegmentInterface $name) {
    $name = (string)$name;
    if (!isset($this->types[$name])) $this->types[$name] = new Type($name);
    return $this->types[$name];
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
    $this->globalData = [];
    foreach ($this->config->getGlobalDataFiles() as $path) {
      $this->globalData = array_replace_recursive($this->globalData, self::loadData($path));
    }
    $this->loadListItems();
  }

  /**
   * Load list items data for patterns
   */
  protected function loadListItems() {
    $this->globalData['listitems'] = [];
    foreach ($this->config->getListItemFiles() as $path) {
      $this->globalData['listitems'] = array_merge($this->globalData['listitems'], self::loadData($path));
    }
    shuffle($this->globalData['listitems']);
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
