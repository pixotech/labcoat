<?php

namespace Labcoat\Configuration;

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

  public function getPatternsDirectory() {
    return $this->patternsDirectory;
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
}