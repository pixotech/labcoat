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
}