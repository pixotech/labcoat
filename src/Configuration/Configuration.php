<?php

namespace Labcoat\Configuration;

use Labcoat\PatternLab;
use Symfony\Component\Yaml\Yaml;

class Configuration implements ConfigurationInterface {

  protected $annotationsPath;

  protected $assetDirectories = [];

  protected $dataFiles = [];

  protected $exposedOptions = [];

  protected $hiddenControls = [];

  protected $ignoredDirectories = [];

  protected $ignoredExtensions = [];

  protected $listItemFiles = [];

  protected $patternExtension = 'twig';

  protected $patternsDirectory;

  protected $styleguideAssetsDirectory;

  protected $styleguideFooterPath;

  protected $styleguideHeaderPath;

  protected $styleguideTemplatesDirectory;

  protected $twigOptions = [];

  public static function fromStandardEdition($dir) {
    $config = new Configuration();
    $configPath = PatternLab::makePath([$dir, 'config', 'config.yml']);
    if (is_file($configPath)) {
      $seConfig = Yaml::parse(file_get_contents($configPath));

      if (!empty($seConfig['sourceDir'])) {
        $sourceDir = PatternLab::makePath([$dir, $seConfig['sourceDir']]);
        if (is_dir($sourceDir)) {

          $config->addAssetDirectory($sourceDir);

          $patternsDir = PatternLab::makePath([$sourceDir, '_patterns']);
          if (is_dir($patternsDir)) {
            $config->setPatternsDirectory($patternsDir);
          }

          $dataDir = PatternLab::makePath([$sourceDir, '_data']);
          if (is_dir($dataDir)) {
            foreach (glob(PatternLab::makePath([$dataDir, '*.json'])) as $path) {
              if (basename($path) == 'listitems.json') $config->addListItems($path);
              else $config->addGlobalData($path);
            }
          }

          $annotationsPath = PatternLab::makePath([$sourceDir, '_annotations', 'annotations.js']);
          if (is_file($annotationsPath)) {
            $config->setAnnotationsFile($annotationsPath);
          }

          $headerPath = PatternLab::makePath([$sourceDir, '_meta', '_00-head.twig']);
          if (is_file($headerPath)) {
            $config->setStyleguideHeader($headerPath);
          }

          $footerPath = PatternLab::makePath([$sourceDir, '_meta', '_01-foot.twig']);
          if (is_file($footerPath)) {
            $config->setStyleguideFooter($footerPath);
          }
        }
      }

      if (!empty($seConfig['packagesDir'])) {
        $packagesDir = PatternLab::makePath([$dir, $seConfig['packagesDir']]);
        if (is_dir($packagesDir)) {

          $assetsDir = PatternLab::makePath([$packagesDir, 'pattern-lab', 'styleguidekit-assets-default', 'dist']);
          if (is_dir($assetsDir)) {
            $config->setStyleguideAssetsDirectory($assetsDir);
          }

          if (!empty($seConfig['styleguideKit'])) {
            $templatesDir = PatternLab::makePath([$packagesDir, $seConfig['styleguideKit'], 'views']);
            if (is_dir($templatesDir)) {
              $config->setStyleguideTemplatesDirectory($templatesDir);
            }
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

  public function addAssetDirectory($path) {
    $this->assetDirectories[] = $path;
  }

  public function addGlobalData($path) {
    $this->dataFiles[] = $path;
  }

  public function addListItems($path) {
    $this->listItemFiles[] = $path;
  }

  public function getAnnotationsFile() {
    return $this->annotationsPath;
  }

  public function getAssetDirectories() {
    return $this->assetDirectories;
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

  public function getStyleguideAssetsDirectory() {
    return $this->styleguideAssetsDirectory;
  }

  public function getStyleguideFooter() {
    return $this->styleguideFooterPath;
  }

  public function getStyleguideHeader() {
    return $this->styleguideHeaderPath;
  }

  public function getStyleguideTemplatesDirectory() {
    return $this->styleguideTemplatesDirectory;
  }

  /**
   * @return array
   */
  public function getTwigOptions() {
    return $this->twigOptions;
  }

  public function setAnnotationsFile($path) {
    $this->annotationsPath = $path;
  }

  public function setExposedOptions($options) {
    $this->exposedOptions = $options;
  }

  public function setHiddenControls($controls) {
    $this->hiddenControls = $controls;
  }

  public function setIgnoredDirectories(array $directories) {
    $this->ignoredDirectories = $directories;
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

  public function setStyleguideAssetsDirectory($path) {
    $this->styleguideAssetsDirectory = $path;
  }

  public function setStyleguideFooter($path) {
    $this->styleguideFooterPath = $path;
  }

  public function setStyleguideHeader($path) {
    $this->styleguideHeaderPath = $path;
  }

  public function setStyleguideTemplatesDirectory($path) {
    $this->styleguideTemplatesDirectory = $path;
  }

  public function setTwigOptions(array $options) {
    $this->twigOptions = $options;
  }
}