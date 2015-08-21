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
  protected $layouts;
  protected $macros;
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

  public function getConfigurationValue($key, $default = null) {
    return isset($this->config[$key]) ? $this->config[$key] : $default;
  }

  /**
   * @return \SplFileInfo[]
   */
  public function getLayoutFiles() {
    return $this->getFilesInDirectoryWithExtension($this->getLayoutsDirectoryPath(), $this->getPatternExtension());
  }

  public function getLayoutFile($name) {
    $layouts = $this->getLayouts();
    return $layouts[$name];
  }

  public function getLayouts() {
    if (!isset($this->layouts)) {
      $this->layouts = [];
      $dir = $this->getLayoutsDirectoryPath();
      foreach ($this->getLayoutFiles() as $file) {
        $filename = $this->getRelativePath($dir, $file->getPathname());
        $this->layouts[$filename] = $file;
      }
    }
    return $this->layouts;
  }

  public function getLayoutsDirectoryPath() {
    return $this->getSourceSubdirectoryPath('_layouts');
  }

  public function getPattern($name) {
    return $this->getPatterns()->get($name);
  }

  public function getPatternExtension() {
    return $this->getTemplateExtension();
  }

  /**
   * @return PatternCollection
   */
  public function getPatterns() {
    if (!isset($this->patterns)) $this->patterns = new PatternCollection($this);
    return $this->patterns;
  }

  public function getPatternsDirectoryPath() {
    return $this->getSourceSubdirectoryPath('_patterns');
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
    return $this->path . DIRECTORY_SEPARATOR . $this->getConfigurationValue('sourceDir', 'source');
  }

  public function getTemplateExtension() {
    return $this->getConfigurationValue('patternExtension', 'twig');
  }

  public function hasConfiguration() {
    return is_file($this->getConfigurationFilePath());
  }

  public function hasLayout($name) {
    return array_key_exists($name, $this->getLayouts());
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

  protected function getFilesInDirectoryIterator($directory) {
    $dir = new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS);
    return new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::LEAVES_ONLY);
  }

  /**
   * @param $directory
   * @param $extension
   * @return \SplFileInfo[]
   */
  protected function getFilesInDirectoryWithExtension($directory, $extension) {
    return iterator_to_array($this->getFilesInDirectoryWithExtensionIterator($directory, $extension), false);
  }

  /**
   * @param $directory
   * @param $extension
   * @return \RegexIterator
   */
  protected function getFilesInDirectoryWithExtensionIterator($directory, $extension) {
    $pattern = '|\.' . preg_quote($extension) . '$|';
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));
    return new \RegexIterator($files, $pattern, \RegexIterator::MATCH);
  }

  protected function getIgnoredAssetDirectories() {
    return $this->getConfigurationValue('id', []);
  }

  protected function getIgnoredAssetExtensions() {
    return $this->getConfigurationValue('ie', []);
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
    return $this->getFilesInDirectoryWithExtensionIterator($this->getPatternsDirectoryPath(), $this->getPatternExtension());
  }

  protected function getRelativePath($directory, $fullPath) {
    return substr($fullPath, strlen($directory) + 1);
  }

  protected function getSourceFilesIterator() {
    return $this->getFilesInDirectoryIterator($this->getSourceDirectoryPath());
  }

  protected function getSourceSubdirectoryPath($dir) {
    return $this->getSourceDirectoryPath() . DIRECTORY_SEPARATOR . $dir;
  }

  protected function getTwigComponentsSubdirectoryPath($dir) {
    return $this->getSourceSubdirectoryPath('_twig-components' . DIRECTORY_SEPARATOR . $dir);
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