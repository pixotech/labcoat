<?php

namespace Labcoat\Configuration;

use Symfony\Component\Yaml\Yaml;

class Configuration implements ConfigurationInterface {

  protected $config;

  public static function load($path) {
    if (!is_file($path)) throw new \Exception("File not found: $path");
    return new static(static::parse($path));
  }

  public static function parse($path) {
    return Yaml::parse(file_get_contents($path));
  }

  public function __construct(array $config = null) {
    $this->config = isset($config) ? $config : [];
  }

  public function get($key, $default = null) {
    return isset($this->config[$key]) ? $this->config[$key] : $default;
  }

  public function getIgnoredAssetDirectories() {
    return $this->get('id', []);
  }

  public function getIgnoredAssetExtensions() {
    return $this->get('ie', []);
  }

  public function getPatternExtension() {
    return $this->get('patternExtension', 'twig');
  }

  public function getSourceDirectory() {
    return $this->get('sourceDir', 'source');
  }
}