<?php

namespace Labcoat;

use Labcoat\Assets\Asset;
use Labcoat\Assets\AssetCollection;
use Labcoat\Patterns\Pattern;
use Labcoat\Patterns\PatternCollection;
use Symfony\Component\Yaml\Yaml;

class PatternLab implements PatternLabInterface {

  protected $assets;
  protected $config;
  protected $path;
  protected $patterns;
  protected $types;

  public static function stripNumbering($str) {
    return preg_match('/^[0-9]+-(.+)$/', $str, $matches) ? $matches[1] : $str;
  }

  public function __construct($path) {
    if (!is_dir($path)) throw new \InvalidArgumentException("Not a directory: $path");
    $this->path = $path;
    if ($this->hasConfiguration()) $this->loadConfiguration();
    $this->loadPatterns();
    $this->loadAssets();
  }

  /**
   * @return AssetCollection
   */
  public function getAssets() {
    return $this->assets;
  }

  public function getConfiguration() {
    return $this->config;
  }

  public function getConfigurationFilePath() {
    return $this->path . '/config/config.yml';
  }

  public function getPattern($name) {
    return $this->getPatterns()->get($name);
  }

  public function getPatternExtension() {
    return !empty($this->config['patternExtension']) ? $this->config['patternExtension'] : 'twig';
  }

  /**
   * @return PatternCollection
   */
  public function getPatterns() {
    if (!isset($this->patterns)) $this->patterns = new PatternCollection($this);
    return $this->patterns;
  }

  public function getPatternsDirectoryPath() {
    return $this->getSourceDirectoryPath() . '/_patterns';
  }

  public function getPatternTypes() {
    if (!isset($this->types)) {
      $this->types = [];
      foreach (new \FilesystemIterator($this->getPatternsDirectoryPath(), \FilesystemIterator::SKIP_DOTS) as $dir) {
        if ($dir->isDir()) $this->types[] = self::stripNumbering($dir->getFilename());
      }
    }
    return $this->types;
  }

  public function getSourceDirectoryPath() {
    $dir = !empty($this->config['sourceDir']) ? $this->config['sourceDir'] : 'source';
    return $this->path . "/$dir";
  }

  public function hasConfiguration() {
    return is_file($this->getConfigurationFilePath());
  }

  public function loadAssets() {
    $this->assets = new AssetCollection();
    foreach ($this->getSourceFilesIterator() as $path => $file) {
      $path = $this->getPathRelativeToSourceDirectory($path);
      if ($this->isAssetPath($path)) $this->assets->add(new Asset($path, $file));
    }
  }

  public function loadConfiguration() {
    if (!$this->hasConfiguration()) throw new \Exception("No configuration file");
    $this->config = Yaml::parse(file_get_contents($this->getConfigurationFilePath()));
  }

  protected function getIgnoredAssetDirectories() {
    return !empty($this->config['id']) ? $this->config['id'] : [];
  }

  protected function getIgnoredAssetExtensions() {
    return !empty($this->config['ie']) ? $this->config['ie'] : [];
  }

  protected function getPathExtension($path) {
    return substr($path, strrpos($path, '.') + 1);
  }

  protected function getPathRelativeToPatternsDirectory($path) {
    return substr($path, strlen($this->getPatternsDirectoryPath()) + 1);
  }

  protected function getPathRelativeToSourceDirectory($path) {
    return substr($path, strlen($this->getSourceDirectoryPath()) + 1);
  }

  protected function getPatternFilesIterator() {
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->getPatternsDirectoryPath()));
    return new \RegexIterator($files, $this->getPatternPathRegex(), \RegexIterator::MATCH);
  }

  protected function getPatternPathRegex() {
    return '|\.' . preg_quote($this->getPatternExtension()) . '$|';
  }

  protected function getSourceFilesIterator() {
    $dir = new \RecursiveDirectoryIterator($this->getSourceDirectoryPath(), \FilesystemIterator::SKIP_DOTS);
    return new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::LEAVES_ONLY);
  }

  protected function hasIgnoredExtension($path) {
    return in_array($this->getPathExtension($path), $this->getIgnoredAssetExtensions());
  }

  protected function isAssetPath($path) {
    if ($path[0] == '_') return false;
    if ($this->hasIgnoredExtension($path)) return false;
    if ($this->isInIgnoredDirectory($path)) return false;
    return true;
  }

  protected function isInIgnoredDirectory($path) {
    return array_intersect(explode(DIRECTORY_SEPARATOR, dirname($path)), $this->getIgnoredAssetDirectories()) ? true : false;
  }

  protected function loadPatterns() {
    $this->patterns = new PatternCollection();
    foreach ($this->getPatternFilesIterator() as $path => $file) {
      $this->patterns->add(new Pattern($this->getPathRelativeToPatternsDirectory($path), $file));
    }
  }
}