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
use Labcoat\Filters\PatternFilterIterator;
use Labcoat\Filters\PatternSelectorFilterIterator;
use Labcoat\Patterns\Pattern;
use Labcoat\Sections\Type;

class PatternLab implements PatternLabInterface {

  use HasItemsTrait;

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
    return false !== strpos($name, '/');
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
    return implode(DIRECTORY_SEPARATOR, $segments);
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
    $stripDigits = ['Labcoat\\PatternLab', 'stripDigits'];
    return implode('/', array_map($stripDigits, explode(DIRECTORY_SEPARATOR, $path)));
  }

  /**
   * Remove ordering digits from a path segment
   *
   * @param string $str A path segment
   * @return string The path without any ordering digits
   */
  public static function stripDigits($str) {
    list($num, $name) = array_pad(explode('-', $str, 2), 2, NULL);
    return is_numeric($num) ? $name : $str;
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
   * Display a text representation of the Pattern Lab
   *
   * @return string A list of Pattern Lab contents, indented to show nesting depth
   */
  public function __toString() {
    $str = '';
    foreach (new \RecursiveIteratorIterator($this, \RecursiveIteratorIterator::SELF_FIRST) as $item) {
      $depth = count(preg_split('/[\/~]/', $item->getPath())) - 1;
      $str .= str_repeat('- ', $depth) . $item->getPath() . "\n";
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
  public function getPattern($name) {
    if ($this->isPathName($name)) {
      $name = $this->normalizePath($this->stripPatternExtensionFromPath($name));
    }
    $patterns = new \RecursiveIteratorIterator($this, \RecursiveIteratorIterator::SELF_FIRST);
    $filter = new PatternSelectorFilterIterator($patterns, $name);
    foreach ($filter as $pattern) return $pattern;
    throw new \OutOfBoundsException("Unknown pattern: $name");
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
    return iterator_to_array($this->getPatternsIterator(), false);
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
    $flags = \FilesystemIterator::CURRENT_AS_PATHNAME | \FilesystemIterator::SKIP_DOTS;
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, $flags));
    $pattern = '|\.' . preg_quote($ext) . '$|';
    $matches = new \RegexIterator($files, $pattern, \RegexIterator::MATCH);
    foreach ($matches as $match) {
      $path = substr($match, strlen($dir) + 1, -1 - strlen($ext));
      list($type) = explode(DIRECTORY_SEPARATOR, $path);
      $this->getOrCreateType($type)->addPattern(new Pattern($path, $match));
    }
  }

  /**
   * Look for a type with the provided path, and create it if it doesn't exist
   *
   * @param string $path The type path
   * @return \Labcoat\Sections\TypeInterface A pattern type object
   */
  protected function getOrCreateType($path) {
    list($key) = explode('/', $this->normalizePath($path));
    if (!isset($this->items[$key])) $this->items[$key] = new Type($path);
    return $this->items[$key];
  }

  /**
   * Get an iterator for all patterns in the installation
   *
   * @return PatternFilterIterator An iterator object
   */
  protected function getPatternsIterator() {
    $items = new \RecursiveIteratorIterator($this, \RecursiveIteratorIterator::SELF_FIRST);
    return new PatternFilterIterator($items);
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