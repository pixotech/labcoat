<?php

namespace Labcoat\Configuration;

use Symfony\Component\Yaml\Yaml;

class Configuration implements ConfigurationInterface {

  protected $config;

  public static function load($path) {
    if (!is_file($path)) throw new \Exception("File not found: $path");
    return new static(file_get_contents($path));
  }

  public function __construct($config = null) {
    if (is_string($config)) $config = Yaml::parse($config);
    $this->config = is_array($config) ? $config : [];
  }

  public function get($key, $default = null) {
    return isset($this->config[$key]) ? $this->config[$key] : $default;
  }

  public function getIgnoredDirectories() {
    return $this->get('id', []);
  }

  public function getIgnoredExtensions() {
    return $this->get('ie', []);
  }

  public function getPatternExtension() {
    return $this->get('patternExtension', 'twig');
  }

  public function getSourceDirectory() {
    return $this->get('sourceDir', 'source');
  }
}