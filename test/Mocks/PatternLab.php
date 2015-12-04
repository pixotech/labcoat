<?php

namespace Labcoat\Mocks;

use Labcoat\Data\DataInterface;
use Labcoat\PatternLabInterface;
use Labcoat\Patterns\PatternInterface;

class PatternLab implements PatternLabInterface {

  public $assets = [];
  public $hiddenControls = [];
  public $ignoredExtensions = [];
  public $patterns = [];
  public $types = [];

  public function getIgnoredExtensions() {
    return $this->ignoredExtensions;
  }

  public function getIgnoredDirectories() {
    // TODO: Implement getIgnoredDirectories() method.
  }

  public function getPatternExtension() {
    // TODO: Implement getPatternExtension() method.
  }

  public function getAssets() {
    return $this->assets;
  }

  public function getPatterns() {
    // TODO: Implement getPatterns() method.
  }

  public function getPatternsDirectory() {
    // TODO: Implement getPatternsDirectory() method.
  }

  public function getAnnotationsFile() {
    // TODO: Implement getAnnotationsFile() method.
  }

  public function getGlobalData() {
    // TODO: Implement getGlobalData() method.
  }

  public function getHiddenControls() {
    return $this->hiddenControls;
  }

  public function getStyleguideFooter() {
    // TODO: Implement getStyleguideFooter() method.
  }

  public function getStyleguideHeader() {
    // TODO: Implement getStyleguideHeader() method.
  }

  public function getStyleguideTemplatesDirectory() {
    // TODO: Implement getStyleguideTemplatesDirectory() method.
  }

  public function isHiddenFile($path) {
    // TODO: Implement isHiddenFile() method.
  }

  public function isIgnoredFile($path) {
    // TODO: Implement isIgnoredFile() method.
  }

  public function getStyleguideAssetDirectories() {
    // TODO: Implement getStyleguideAssetDirectories() method.
  }

  public function hasIgnoredExtension($path) {
    // TODO: Implement hasIgnoredExtension() method.
  }

  public function isInIgnoredDirectory($path) {
    // TODO: Implement isInIgnoredDirectory() method.
  }

  public function getTypes() {
    return $this->types;
  }

  public function render(PatternInterface $pattern, DataInterface $data = NULL) {
    // TODO: Implement render() method.
  }

  public function getPatternsThatInclude(PatternInterface $pattern) {
    // TODO: Implement getPatternsThatInclude() method.
  }
}