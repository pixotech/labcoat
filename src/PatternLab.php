<?php

namespace Labcoat;

use Labcoat\Assets\Asset;
use Labcoat\Assets\Copier;
use Labcoat\Configuration\Configuration;
use Labcoat\Filesystem\Directory;
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
   * @var Configuration
   */
  protected $config;

  protected $patternsDirectory;

  /**
   * @var \Labcoat\Patterns\PatternCollection
   */
  protected $patterns;

  /**
   * @var \Labcoat\Twig\Environment
   */
  protected $twig;

  /**
   * @var array
   */
  protected $twigOptions = [];

  public function __construct() {
  }



  public function setPatternsDirectory($path) {
    $this->patternsDirectory = $path;
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

  public function getDataDirectory() {
    return $this->patternsDirectory . '/../_data';
  }

  public function getDefaultDirectoryPermissions() {
    return 0777;
  }

  public function getExposedOptions() {
    return [];
  }

  public function getHiddenControls() {
    return [];
  }

  /**
   * Get an array of ignored asset directories
   *
   * This list is taken from the configuration file value "id".
   *
   * @return array
   */
  public function getIgnoredDirectories() {
    return $this->getConfiguration()->getIgnoredDirectories();
  }

  /**
   * Get an array of ignored asset extensions
   *
   * This list is taken from the configuration file value "ie".
   *
   * @return array
   */
  public function getIgnoredExtensions() {
    return $this->getConfiguration()->getIgnoredExtensions();
  }

  public function getMediaQueries() {
    return [];
  }

  public function getMetaDirectory() {
    return $this->patternsDirectory . '/../_meta';
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
    return 'twig';
  }

  public function getPatterns() {
    if (!isset($this->patterns)) $this->patterns = new PatternCollection($this);
    return $this->patterns;
  }

  public function getPatternsDirectory() {
    return $this->patternsDirectory;
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

  protected function findPatterns() {
    $this->patterns = [];
    foreach ($this->getPatternFiles() as $file) {
      if ($file->hasPatternExtension() && !$file->isHidden()) {
        $this->patterns[] = new Pattern($file);
      }
    }
  }

  /**
   * @return \Labcoat\Configuration\ConfigurationInterface
   */
  protected function getConfiguration() {
    if (!isset($this->config)) $this->loadConfiguration();
    return $this->config;
  }

  protected function getConfigurationFile() {
    return $this->directory->getFile(['config', 'config.yml']);
  }

  /**
   * @return \Labcoat\Filesystem\File[]
   */
  protected function getPatternFiles() {
    return $this->getPatternsDirectory()->getPatternFiles();
  }

  protected function getPatternsIterator() {
    return new \ArrayIterator($this->getPatterns());
  }

  /**
   * @return \SplFileInfo[]
   */
  protected function getStylesheets() {
    $finder = new Finder();
    $finder->files()->name("*.css")->in($this->getSourceDirectoryPath());
    $finder->sortByName();
    return iterator_to_array($finder, false);
  }

  protected function loadConfiguration() {
    $this->config = Configuration::load($this->getConfigurationFile()->getFullPath());
  }

  protected function makeTwig() {
    $this->twig = new Environment($this, $this->twigOptions);
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