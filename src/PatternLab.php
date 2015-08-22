<?php

namespace Labcoat;

use Labcoat\Assets\Asset;
use Labcoat\Assets\AssetCollection;
use Labcoat\Configuration\Configuration;
use Labcoat\Filesystem\Directory;
use Labcoat\Html\Document;
use Labcoat\Patterns\Pattern;
use Labcoat\Patterns\PatternCollection;
use Labcoat\Twig\Environment;

class PatternLab implements PatternLabInterface {

  /**
   * @var AssetCollection
   */
  protected $assets;

  /**
   * @var Configuration
   */
  protected $config;

  /**
   * @var Directory
   */
  protected $directory;

  /**
   * @var array
   */
  protected $layouts;

  /**
   * @var PatternCollection
   */
  protected $patterns;

  /**
   * @var \Labcoat\Twig\Environment
   */
  protected $twig;

  /**
   * @var array
   */
  protected $twigOptions;

  public static function stripNumbering($str) {
    return preg_match('/^[0-9]+-(.+)$/', $str, $matches) ? $matches[1] : $str;
  }

  public function __construct($path, array $twigOptions = []) {
    $this->directory = new Directory($this, $path);
    $this->twigOptions = $twigOptions;
  }

  public function copyAssetsTo($directoryPath) {
    $this->assets->copyTo($directoryPath);
  }

  public function getIgnoredDirectories() {
    return $this->getConfiguration()->getIgnoredDirectories();
  }

  public function getIgnoredExtensions() {
    return $this->getConfiguration()->getIgnoredExtensions();
  }

  public function getLayout($name) {
    return $this->getLayouts()[$name];
  }

  public function getPattern($name) {
    return $this->getPatterns()->get($name);
  }

  public function getPatternExtension() {
    return $this->getConfiguration()->getPatternExtension();
  }

  public function hasLayout($name) {
    return array_key_exists($name, $this->getLayouts());
  }

  public function makeDocument($patternName, $variables = null) {
    return new Document($this->render($patternName, $variables));
  }

  public function render($patternName, $variables = null) {
    if (is_object($variables)) $variables = get_object_vars($variables);
    return $this->getTwig()->render($patternName, $variables ?: []);
  }

  protected function findAssets() {
    $this->assets = new AssetCollection();
    foreach ($this->getSourceFiles() as $file) {
      if (!$file->isHidden() && !$file->isIgnored()) {
        $this->assets->add(new Asset($this, $file));
      }
    }
  }

  protected function findLayouts() {
    $this->layouts = [];
    foreach ($this->getLayoutFiles() as $file) {
      if (!$file->isHidden()) {
        $this->layouts[$file->getPath()] = $file->getFullPath();
      }
    }
  }

  protected function findPatterns() {
    $this->patterns = new PatternCollection();
    foreach ($this->getPatternFiles() as $file) {
      if ($file->hasPatternExtension() && !$file->isHidden()) {
        $this->patterns->add(new Pattern($this, $file));
      }
    }
  }

  protected function getAssets() {
    if (!isset($this->assets)) $this->findAssets();
    return $this->assets;
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
   * @return Filesystem\File[]
   */
  protected function getLayoutFiles() {
    $directory = $this->getSourceDirectory()->getDirectory('_layouts');
    return $directory->getFilesWithExtension('twig');
  }

  protected function getLayouts() {
    if (!isset($this->layouts)) $this->findLayouts();
    return $this->layouts;
  }

  protected function getPatterns() {
    if (!isset($this->patterns)) $this->findPatterns();
    return $this->patterns;
  }

  /**
   * @return Directory
   */
  public function getPatternsDirectory() {
    return $this->getSourceDirectory()->getDirectory('_patterns');
  }

  /**
   * @return \Labcoat\Filesystem\File[]
   */
  protected function getPatternFiles() {
    return $this->getPatternsDirectory()->getPatternFiles();
  }

  /**
   * @return Directory
   */
  protected function getSourceDirectory() {
    return $this->directory->getDirectory($this->getSourceDirectoryPath());
  }

  /**
   * @return string
   */
  protected function getSourceDirectoryPath() {
    return $this->getConfiguration()->getSourceDirectory();
  }

  /**
   * @return \Labcoat\Filesystem\File[]
   */
  protected function getSourceFiles() {
    return $this->getSourceDirectory()->getFiles();
  }

  protected function getTwig() {
    if (!isset($this->twig)) $this->makeTwig();
    return $this->twig;
  }

  protected function loadConfiguration() {
    $this->config = Configuration::load($this->getConfigurationFile()->getFullPath());
  }

  protected function makeTwig() {
    $this->twig = new Environment($this, $this->twigOptions);
  }
}