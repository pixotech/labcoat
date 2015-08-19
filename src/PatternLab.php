<?php

namespace Pixo\PatternLab;

use Pixo\PatternLab\Patterns\Pattern;
use Pixo\PatternLab\Patterns\PatternCollection;
use Symfony\Component\Yaml\Yaml;

class PatternLab implements PatternLabInterface {

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
  }

  public function getConfiguration() {
    return $this->config;
  }

  public function getConfigurationFilePath() {
    return $this->path . '/config/config.yml';
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
    $dir = !empty($config['sourceDir']) ? $config['sourceDir'] : 'source';
    return $this->path . "/$dir";
  }

  public function hasConfiguration() {
    return is_file($this->getConfigurationFilePath());
  }

  public function loadConfiguration() {
    if (!$this->hasConfiguration()) throw new \Exception("No configuration file");
    $this->config = Yaml::parse(file_get_contents($this->getConfigurationFilePath()));
  }

  protected function getPathRelativeToPatternsDirectory($path) {
    return substr($path, strlen($this->getPatternsDirectoryPath()) + 1);
  }

  protected function getPatternFilesIterator() {
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->getPatternsDirectoryPath()));
    return new \RegexIterator($files, $this->getPatternPathRegex(), \RegexIterator::MATCH);
  }

  protected function getPatternPathRegex() {
    return '|\.' . preg_quote($this->getPatternExtension()) . '$|';
  }

  protected function loadPatterns() {
    $this->patterns = new PatternCollection();
    foreach ($this->getPatternFilesIterator() as $path => $file) {
      $this->patterns->add(new Pattern($this->getPathRelativeToPatternsDirectory($path), $file));
    }
  }
}