<?php

namespace Labcoat\Configuration;

use Symfony\Component\Yaml\Yaml;

class Configuration implements ConfigurationInterface {

  protected $assetDirectories = [];

  protected $dataFiles = [];

  protected $exposedOptions = [];

  protected $hiddenControls = [];

  protected $ignoredDirectories = [];

  protected $ignoredExtensions = [];

  protected $listItemFiles = [];

  protected $patternExtension = 'twig';

  protected $patternsDirectory;

  protected $styleguideFooterPath;

  protected $styleguideHeaderPath;

  protected $twigOptions = [];

  public static function fromStandardEdition($dir) {
    $config = new Configuration();
    $configPath = self::makePath([$dir, 'config', 'config.yml']);
    if (is_file($configPath)) {
      $seConfig = Yaml::parse(file_get_contents($configPath));
      if (!empty($seConfig['sourceDir'])) {
        $sourceDir = self::makePath([$dir, $seConfig['sourceDir']]);
        if (is_dir($sourceDir)) {
          $config->addAssetDirectory($sourceDir);

          $patternsDir = self::makePath([$sourceDir, '_patterns']);
          if (is_dir($patternsDir)) {
            $config->setPatternsDirectory($patternsDir);
          }

          $dataDir = self::makePath([$sourceDir, '_data']);
          if (is_dir($dataDir)) {
            foreach (glob(self::makePath([$dataDir, '*.json'])) as $path) {
              if (basename($path) == 'listitems.json') $config->addListItems($path);
              else $config->addGlobalData($path);
            }
          }

          $headerPath = self::makePath([$sourceDir, '_meta', '_00-head.twig']);
          if (is_file($headerPath)) {
            $config->setStyleguideHeader($headerPath);
          }

          $footerPath = self::makePath([$sourceDir, '_meta', '_01-foot.twig']);
          if (is_file($footerPath)) {
            $config->setStyleguideFooter($footerPath);
          }
        }
      }
      if (!empty($seConfig['id'])) {
        $config->setIgnoredDirectories($seConfig['id']);
      }
      if (!empty($seConfig['ie'])) {
        $config->setIgnoredExtensions($seConfig['ie']);
      }
      if (!empty($seConfig['ishControlsHide'])) {
        $config->setHiddenControls($seConfig['ishControlsHide']);
      }
      if (!empty($seConfig['patternExtension'])) {
        $config->setPatternExtension($seConfig['patternExtension']);
      }
    }
    return $config;
  }

  protected static function makePath(array $segments) {
    return implode(DIRECTORY_SEPARATOR, $segments);
  }

  public function addAssetDirectory($path) {
    $this->assetDirectories[] = $path;
  }

  public function addGlobalData($path) {
    $this->dataFiles[] = $path;
  }

  public function addListItems($path) {
    $this->listItemFiles[] = $path;
  }

  public function getExposedOptions() {
    return $this->exposedOptions;
  }

  public function getGlobalDataFiles() {
    return $this->dataFiles;
  }

  public function getHiddenControls() {
    return $this->hiddenControls;
  }

  public function getIgnoredDirectories() {
    return $this->ignoredDirectories;
  }

  public function getIgnoredExtensions() {
    return $this->ignoredExtensions;
  }

  public function getListItemFiles() {
    return $this->listItemFiles;
  }

  public function getPatternExtension() {
    return $this->patternExtension;
  }

  public function getPatternsDirectory() {
    return $this->patternsDirectory;
  }

  public function getStyleguideFooter() {
    return $this->styleguideFooterPath;
  }

  public function getStyleguideHeader() {
    return $this->styleguideHeaderPath;
  }

  /**
   * @return array
   */
  public function getTwigOptions() {
    return $this->twigOptions;
  }

  public function setIgnoredDirectories(array $directories) {
    $this->ignoredDirectories = $directories;
  }

  public function setExposedOptions($options) {
    $this->exposedOptions = $options;
  }

  public function setHiddenControls($controls) {
    $this->hiddenControls = $controls;
  }

  public function setIgnoredExtensions(array $extensions) {
    $this->ignoredExtensions = $extensions;
  }

  public function setPatternExtension($extension) {
    $this->patternExtension = $extension;
  }

  public function setPatternsDirectory($path) {
    $this->patternsDirectory = $path;
  }

  public function setStyleguideFooter($path) {
    $this->styleguideFooterPath = $path;
  }

  public function setStyleguideHeader($path) {
    $this->styleguideHeaderPath = $path;
  }

  public function setTwigOptions(array $options) {
    $this->twigOptions = $options;
  }
}