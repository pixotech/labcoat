<?php

namespace Labcoat;

use Labcoat\Assets\Asset;
use Labcoat\Assets\Copier;
use Labcoat\Configuration\Configuration;
use Labcoat\Configuration\ConfigurationInterface;
use Labcoat\Html\Document;
use Labcoat\Patterns\Pattern;
use Labcoat\Patterns\PatternCollection;
use Labcoat\Twig\Environment;

class PatternLab implements PatternLabInterface {

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
   * @var \Labcoat\Patterns\PatternCollection
   */
  protected $patterns;

  /**
   * @var \Labcoat\Twig\Environment
   */
  protected $twig;

  public static function loadData($path) {
    return json_decode(file_get_contents($path), true);
  }

  public static function loadStandardEdition($dir) {
    $config = Configuration::fromStandardEdition($dir);
    return new PatternLab($config);
  }

  public static function isPartialName($name) {
    return FALSE === strpos($name, '/');
  }

  public static function splitPartial($partial) {
    return explode('-', $partial, 2);
  }

  public static function splitPath($path) {
    $parts = explode('/', $path);
    if (count($parts) == 3) {
      return $parts;
    }
    if (count($parts) == 2) {
      return [$parts[0], NULL, $parts[1]];
    }
    throw new \InvalidArgumentException("Invalid path: $path");
  }

  public static function stripDigits($str) {
    list($num, $name) = array_pad(explode('-', $str, 2), 2, NULL);
    return is_numeric($num) ? $name : $str;
  }

  public function __construct(ConfigurationInterface $config) {
    $this->config = $config;
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

  /**
   * Copy all assets to another directory
   *
   * Copies all Pattern Lab assets that are not hidden or ignored. Missing subdirectories will be created as needed.
   *
   * @param string $directoryPath The full path to the destination directory
   */
  public function copyAssetsTo($directoryPath) {
    $copier = new Copier($this);
    $copier->copyTo($directoryPath);
  }

  public function getDefaultDirectoryPermissions() {
    return 0777;
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
    $name = $this->stripPatternExtensionFromPath($name);
    return $this->getPatterns()->getPattern($name);
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
    if (!isset($this->patterns)) $this->patterns = new PatternCollection($this);
    return $this->patterns;
  }

  public function getPatternsDirectory() {
    return $this->config->getPatternsDirectory();
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
   * @return Patterns\PatternTypeInterface
   */
  public function getType($name) {
    return $this->getPatterns()->getType($name);
  }

  /**
   * @return \Labcoat\Patterns\PatternTypeInterface[]
   */
  public function getTypes() {
    return $this->getPatterns()->getTypes();
  }

  public function getVendorDirectory() {
    $loaderClassName = "Composer\\Autoload\\ClassLoader";
    if (!class_exists($loaderClassName)) throw new \Exception("Could not location vendor path");
    $reflection = new \ReflectionClass($loaderClassName);
    return realpath(dirname($reflection->getFileName()) . '/..');
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
    foreach ($this->getSourceFiles() as $file) {
      if (!$file->isHidden() && !$file->isIgnored()) {
        $this->assets[] = new Asset($file);
      }
    }
  }

  protected function getPatternsIterator() {
    return new \ArrayIterator($this->getPatterns());
  }

  protected function getTwigOptions() {
    return $this->config->getTwigOptions();
  }

  protected function loadGlobalData() {
    $this->globalData = [];
    foreach ($this->config->getGlobalDataFiles() as $path) {
      $this->globalData = array_merge_recursive($this->globalData, self::loadData($path));
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

  protected function normalizePatternPath($path) {
    $path = $this->stripPatternExtensionFromPath($path);
    return self::normalizePath($path);
  }

  protected function stripPatternExtensionFromPath($path) {
    $ext = '.' . $this->getPatternExtension();
    if (substr($path, 0 - strlen($ext)) == $ext) $path = substr($path, 0, 0 - strlen($ext));
    return $path;
  }
}