<?php

namespace Labcoat\Mocks;

use Labcoat\PatternLabInterface;

class PatternLab implements PatternLabInterface {

  public $ignoredExtensions = [];

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

  public function getPatternsDirectory() {
    // TODO: Implement getPatternsDirectory() method.
  }

  public function makeDocument($patternName, $variables = NULL) {
    // TODO: Implement makeDocument() method.
  }

  public function render($patternName, $variables = NULL) {
    // TODO: Implement render() method.
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
}