<?php

namespace Labcoat;

use Labcoat\Assets\AssetDirectory;
use Labcoat\Configuration\Configuration;
use Labcoat\Configuration\ConfigurationInterface;
use Labcoat\Filters\PatternFilterIterator;
use Labcoat\Filters\PatternSelectorFilterIterator;
use Labcoat\Html\Document;
use Labcoat\Patterns\Pattern;
use Labcoat\Sections\Type;
use Labcoat\Twig\Environment;

class PatternLab implements PatternLabInterface {

  use HasItemsTrait;

  protected $assetsDirectory;

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
   * @var \Labcoat\Twig\Environment
   */
  protected $twig;

  public static function isPartialName($name) {
    return false === strpos($name, '/');
  }

  public static function isPathName($name) {
    return false !== strpos($name, '/');
  }

  public static function loadData($path) {
    return json_decode(file_get_contents($path), true);
  }

  public static function loadStandardEdition($dir) {
    $config = Configuration::fromStandardEdition($dir);
    return new PatternLab($config);
  }

  public static function makePath(array $segments) {
    return implode(DIRECTORY_SEPARATOR, $segments);
  }

  public static function normalizePath($path) {
    $stripDigits = ['Labcoat\\PatternLab', 'stripDigits'];
    return implode('/', array_map($stripDigits, explode(DIRECTORY_SEPARATOR, $path)));
  }

  public static function stripDigits($str) {
    list($num, $name) = array_pad(explode('-', $str, 2), 2, NULL);
    return is_numeric($num) ? $name : $str;
  }

  public function __construct(ConfigurationInterface $config) {
    $this->config = $config;
    $this->findPatterns();
  }

  public function __toString() {
    $str = '';
    foreach (new \RecursiveIteratorIterator($this, \RecursiveIteratorIterator::SELF_FIRST) as $item) {
      $depth = count(preg_split('/[\/~]/', $item->getPath())) - 1;
      $str .= str_repeat('- ', $depth) . $item->getPath() . "\n";
    }
    return $str;
  }

  public function getAnnotationsFile() {
    return $this->config->getAnnotationsFile();
  }

  /**
   * Get an array of Pattern Lab assets
   *
   * @return Assets\Asset[]
   */
  public function getAssets() {



    if (!isset($this->assets)) $this->findAssets();
    return $this->assets;
  }

  public function getExposedOptions() {
    return [];
  }

  public function getGlobalData() {
    if (!isset($this->globalData)) $this->loadGlobalData();
    return $this->globalData;
  }

  public function getHiddenControls() {
    return $this->config->getHiddenControls();
  }

  /**
   * Get an array of ignored asset directories
   *
   * This list is taken from the configuration file value "id".
   *
   * @return array
   */
  public function getIgnoredDirectories() {
    return $this->config->getIgnoredDirectories();
  }

  /**
   * Get an array of ignored asset extensions
   *
   * This list is taken from the configuration file value "ie".
   *
   * @return array
   */
  public function getIgnoredExtensions() {
    return $this->config->getIgnoredExtensions();
  }

  /**
   * Get a pattern by shorthand or path
   *
   * Supported pattern selectors:
   * - Shorthand, e.g. "atoms-button" or "pages-contact". Fuzzy matching is not supported.
   * - Path, relative to the "source/_patterns" directory, without the template extension.
   *   Ordering prefixes are disregarded.
   *
   * @param string $name The path or shorthand name of a pattern
   * @return \Labcoat\Patterns\Pattern
   * @throws \OutOfBoundsException No matching pattern was found
   * @see http://patternlab.io/docs/pattern-including.html "Including Patterns"
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
   * Get the pattern template extension
   *
   * This value comes from the configuration file value "patternExtension".
   *
   * @return string A file extension
   */
  public function getPatternExtension() {
    return $this->config->getPatternExtension();
  }

  public function getPatterns() {
    return iterator_to_array($this->getPatternsIterator(), false);
  }

  public function getPatternsDirectory() {
    return $this->config->getPatternsDirectory();
  }

  public function getStyleguideAssetsDirectory() {
    return $this->config->getStyleguideAssetsDirectory();
  }

  public function getStyleguideFooter() {
    return $this->config->getStyleguideFooter();
  }

  public function getStyleguideHeader() {
    return $this->config->getStyleguideHeader();
  }

  public function getStyleguideTemplatesDirectory() {
    return $this->config->getStyleguideTemplatesDirectory();
  }

  /**
   * Get the Twig parser
   *
   * @return \Labcoat\Twig\Environment The Twig parser
   */
  public function getTwig() {
    if (!isset($this->twig)) $this->makeTwig();
    return $this->twig;
  }

  /**
   * @param string $name
   * @return \Labcoat\Sections\TypeInterface
   */
  public function getType($name) {
    return $this->getPatterns()->getType($name);
  }

  /**
   * @return \Labcoat\Sections\TypeInterface[]
   */
  public function getTypes() {
    return $this->getPatterns()->getTypes();
  }

  public function hasIgnoredExtension($path) {
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    return in_array($ext, $this->getIgnoredExtensions());
  }

  public function hasType($name) {
    return !empty($this->items[$name]);
  }

  public function isHiddenFile($path) {
    return false !== strpos(DIRECTORY_SEPARATOR . $path, DIRECTORY_SEPARATOR . '_');
  }

  public function isIgnoredFile($path) {
    return $this->hasIgnoredExtension($path) || $this->isInIgnoredDirectory($path);
  }

  public function isInIgnoredDirectory($path) {
    $dirs = explode(DIRECTORY_SEPARATOR, dirname($path));
    return count(array_intersect($dirs, $this->getIgnoredDirectories())) > 0;
  }

  /**
   * Create an HTML document from a pattern
   *
   * @param string $patternName The name of the pattern to render
   * @param mixed $variables Variables for the pattern template; can be an array, object, or null
   * @return \Labcoat\Html\Document
   */
  public function makeDocument($patternName, $variables = null) {
    return new Document($this->render($patternName, $variables));
  }

  /**
   * Render a pattern template
   *
   * @param string $patternName The name of the pattern to render
   * @param mixed $variables Variables for the pattern template; can be an array, object, or null
   * @return string The rendered template
   */
  public function render($patternName, $variables = null) {
    if (is_object($variables)) $variables = get_object_vars($variables);
    return $this->getTwig()->render($patternName, $variables ?: []);
  }

  protected function findAssets() {
    $this->assets = [];
    foreach ($this->config->getAssetDirectories() as $dir) {
      $dir = new AssetDirectory($this, $dir);
      $this->assets += $dir->getAssets();
    }
  }

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
   * @param $path
   * @return \Labcoat\Sections\TypeInterface
   */
  protected function getOrCreateType($path) {
    list($key) = explode('/', $this->normalizePath($path));
    if (!isset($this->items[$key])) $this->items[$key] = new Type($path);
    return $this->items[$key];
  }

  protected function getPatternsIterator() {
    $items = new \RecursiveIteratorIterator($this, \RecursiveIteratorIterator::SELF_FIRST);
    return new PatternFilterIterator($items);
  }

  protected function getTwigOptions() {
    return $this->config->getTwigOptions();
  }

  protected function loadGlobalData() {
    $this->globalData = [];
    foreach ($this->config->getGlobalDataFiles() as $path) {
      $this->globalData = array_replace_recursive($this->globalData, self::loadData($path));
    }
    $this->loadListItems();
  }

  protected function loadListItems() {
    $this->globalData['listitems'] = [];
    foreach ($this->config->getListItemFiles() as $path) {
      $this->globalData['listitems'] = array_merge($this->globalData['listitems'], self::loadData($path));
    }
    shuffle($this->globalData['listitems']);
  }

  protected function makeTwig() {
    $this->twig = new Environment($this, $this->getTwigOptions());
  }

  protected function stripPatternExtensionFromPath($path) {
    $ext = '.' . $this->getPatternExtension();
    if (substr($path, 0 - strlen($ext)) == $ext) $path = substr($path, 0, 0 - strlen($ext));
    return $path;
  }
}