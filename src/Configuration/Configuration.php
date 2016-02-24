<?php

namespace Labcoat\Configuration;

use Labcoat\Data\Data;
use Labcoat\PatternLab\Styleguide\Styleguide;
use Labcoat\PatternLabInterface;

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

  protected $styleguideAssetDirectories = [];

  protected $styleguideFooterPath;

  protected $styleguideHeaderPath;

  protected $styleguideTemplatesDirectory;

  protected $twigOptions = [];

  public function addAssetDirectory($path) {
    $this->assetDirectories[] = $path;
  }

  public function addGlobalData($path) {
    $this->dataFiles[] = $path;
  }

  public function addListItems($path) {
    $this->listItemFiles[] = $path;
  }

  public function addStyleguideAssetDirectory($path) {
    $this->styleguideAssetDirectories[] = $path;
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

  /**
   * Look in the pattern directory for pattern templates
   */
  public function getPatterns() {
    $dir = $this->getPatternsDirectory();
    $ext = $this->getPatternExtension();
    $patterns = [];
    foreach ($this->getPatternFilesIterator() as $match => $file) {
      $path = substr($match, strlen($dir) + 1, -1 - strlen($ext));
      $patterns[] = Pattern::makeFromFile($dir, $path, $ext);
    }
    return $patterns;
  }

  public function getPatternsDirectory() {
    return $this->patternsDirectory;
  }

  public function getStyleguide(PatternLabInterface $patternlab) {
    $styleguide = new Styleguide($patternlab);
    $styleguide->setAnnotationsFilePath($this->getAnnotationsFile());
    $styleguide->setGlobalData($this->getDataFromFiles($this->getGlobalDataFiles()));
    $styleguide->setHiddenControls($this->getHiddenControls());
    $styleguide->setPatternFooterTemplatePath($this->getStyleguideFooter());
    $styleguide->setPatternHeaderTemplatePath($this->getStyleguideHeader());
    foreach ($patternlab->getPatterns() as $pattern) {
      $styleguide->addPattern($pattern);
    }
    return $styleguide;
  }

  public function getStyleguideAssetDirectories() {
    return $this->styleguideAssetDirectories;
  }

  public function getStyleguideFooter() {
    return $this->styleguideFooterPath;
  }

  public function getStyleguideHeader() {
    return $this->styleguideHeaderPath;
  }

  public function getStyleguideTemplatesDirectories() {
    return $this->styleguideTemplatesDirectory;
  }

  /**
   * @return array
   */
  public function getTwigOptions() {
    return $this->twigOptions;
  }

  public function hasStyleguideFooter() {
    return !empty($this->styleguideFooterPath);
  }

  public function hasStyleguideHeader() {
    return !empty($this->styleguideHeaderPath);
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

  protected function getDataFromFiles(array $files) {
    $data = new Data();
    foreach ($files as $file) $data->merge(Data::load($file));
    return $data->toArray();
  }

  protected function getPatternFilesIterator() {
    $dir = $this->getPatternsDirectory();
    $ext = $this->getPatternExtension();
    $flags = \FilesystemIterator::SKIP_DOTS;
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, $flags));
    $regex = '|\.' . preg_quote($ext) . '$|';
    return new \RegexIterator($files, $regex, \RegexIterator::MATCH);
  }
}