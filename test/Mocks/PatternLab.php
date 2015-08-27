<?php

namespace Labcoat\Mocks;

use Labcoat\PatternLabInterface;

class PatternLab implements PatternLabInterface {

  public $ignoredExtensions = [];
  public $render;

  public function getIgnoredExtensions() {
    return $this->ignoredExtensions;
  }

  public function copyAssetsTo($directoryPath) {
    // TODO: Implement copyAssetsTo() method.
  }

  public function getIgnoredDirectories() {
    // TODO: Implement getIgnoredDirectories() method.
  }

  public function getPatternExtension() {
    // TODO: Implement getPatternExtension() method.
  }

  public function makeDocument($patternName, $variables = NULL) {
    // TODO: Implement makeDocument() method.
  }

  public function render($patternName, $variables = NULL) {
    return $this->render;
  }

  public function getAssets() {
    // TODO: Implement getAssets() method.
  }

  public function getLayout($name) {
    // TODO: Implement getLayout() method.
  }

  public function getPattern($name) {
    // TODO: Implement getPattern() method.
  }

  public function hasLayout($name) {
    // TODO: Implement hasLayout() method.
  }

  public function getTwig() {
    // TODO: Implement getTwig() method.
  }

  public function getDataDirectory() {
    // TODO: Implement getDataDirectory() method.
  }

  public function getDefaultDirectoryPermissions() {
    // TODO: Implement getDefaultDirectoryPermissions() method.
  }

  public function getExposedOptions() {
    // TODO: Implement getExposedOptions() method.
  }

  public function getMetaDirectory() {
    // TODO: Implement getMetaDirectory() method.
  }

  public function getPatterns() {
    // TODO: Implement getPatterns() method.
  }

  public function getPatternsDirectory() {
    // TODO: Implement getPatternsDirectory() method.
  }

  public function getVendorDirectory() {
    // TODO: Implement getVendorDirectory() method.
  }

  public function setPatternsDirectory($path) {
    // TODO: Implement setPatternsDirectory() method.
  }
}