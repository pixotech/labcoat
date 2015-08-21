<?php

namespace Labcoat;

use Labcoat\Assets\Asset;
use Labcoat\Assets\AssetCollection;
use Labcoat\Configuration\Configuration;
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
  protected $path;

  /**
   * @var PatternCollection
   */
  protected $patterns;

  /**
   * @var \Labcoat\Twig\Environment
   */
  protected $twig;
  protected $twigOptions;

  public static function stripNumbering($str) {
    return preg_match('/^[0-9]+-(.+)$/', $str, $matches) ? $matches[1] : $str;
  }

  public function __construct($path, array $twigOptions = []) {
    if (!is_dir($path)) throw new \InvalidArgumentException("Not a directory: $path");
    $this->path = $path;
    $this->twigOptions = $twigOptions;
    $this->loadConfiguration();
    $this->loadPatterns();
    $this->loadAssets();
  }

  public function copyAssetsTo($directoryPath) {
    $this->assets->copyTo($directoryPath);
  }

  public function makeDocument($patternName, array $variables = []) {
    return new Document($this->render($patternName, $variables));
  }

  public function render($patternName, array $variables = []) {
    return $this->getTwig()->render($patternName, $variables);
  }

  protected function getConfigurationFilePath() {
    return $this->path . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.yml';
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

  protected function getPathExtension($path) {
    return substr($path, strrpos($path, '.') + 1);
  }

  protected function getPathRelativeToPatternsDirectory($path) {
    return substr($path, strlen($this->getPatternsDirectoryPath()) + 1);
  }

  protected function getPathRelativeToSourceDirectory($path) {
    return substr($path, strlen($this->getSourceDirectoryPath()) + 1);
  }

  protected function getPattern($name) {
    return $this->patterns->get($name);
  }

  protected function getPatternsDirectoryPath() {
    return $this->getSourceSubdirectoryPath('_patterns');
  }

  protected function getPatternFilesIterator() {
    return $this->getFilesInDirectoryWithExtensionIterator($this->getPatternsDirectoryPath(), $this->config->getPatternExtension());
  }

  protected function getRelativePath($directory, $fullPath) {
    return substr($fullPath, strlen($directory) + 1);
  }

  protected function getSourceDirectoryPath() {
    return $this->path . DIRECTORY_SEPARATOR . $this->config->getSourceDirectory();
  }

  protected function getSourceFilesIterator() {
    return $this->getFilesInDirectoryIterator($this->getSourceDirectoryPath());
  }

  protected function getSourceSubdirectoryPath($dir) {
    return $this->getSourceDirectoryPath() . DIRECTORY_SEPARATOR . $dir;
  }

  protected function getTwig() {
    if (!isset($this->twig)) {
      $this->twig = new Environment($this, $this->twigOptions);
    }
    return $this->twig;
  }

  protected function hasIgnoredExtension($path) {
    return in_array($this->getPathExtension($path), $this->config->getIgnoredAssetExtensions());
  }

  protected function isAssetPath($path) {
    if ($path[0] == '_') return false;
    if ($this->hasIgnoredExtension($path)) return false;
    if ($this->isInIgnoredDirectory($path)) return false;
    return true;
  }

  protected function isInIgnoredDirectory($path) {
    return array_intersect(explode(DIRECTORY_SEPARATOR, dirname($path)), $this->config->getIgnoredAssetDirectories()) ? true : false;
  }

  protected function loadAssets() {
    $this->assets = new AssetCollection();
    foreach ($this->getSourceFilesIterator() as $path => $file) {
      $path = $this->getPathRelativeToSourceDirectory($path);
      if ($this->isAssetPath($path)) $this->assets->add(new Asset($path, $file));
    }
  }

  protected function loadConfiguration() {
    $this->config = Configuration::load($this->getConfigurationFilePath());
  }

  protected function loadPatterns() {
    $this->patterns = new PatternCollection();
    foreach ($this->getPatternFilesIterator() as $path => $file) {
      $this->patterns->add(new Pattern($this->getPathRelativeToPatternsDirectory($path), $file));
    }
  }
}