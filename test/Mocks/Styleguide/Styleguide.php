<?php

namespace Labcoat\Mocks\Styleguide;

use Labcoat\Styleguide\Patterns\PatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

class Styleguide implements StyleguideInterface {

  public $patternlab;

  public function getGlobalData() {
    // TODO: Implement getGlobalData() method.
  }

  public function getPatternLab() {
    return $this->patternlab;
  }

  public function generate($directory) {
    // TODO: Implement generate() method.
  }

  public function getCacheBuster() {
    // TODO: Implement getCacheBuster() method.
  }

  public function getConfig() {
    // TODO: Implement getConfig() method.
  }

  public function getControls() {
    // TODO: Implement getControls() method.
  }

  public function getIndexPaths() {
    // TODO: Implement getIndexPaths() method.
  }

  public function getPatternData(PatternInterface $pattern) {
    // TODO: Implement getPatternData() method.
  }

  public function getPatternPaths() {
    // TODO: Implement getPatternPaths() method.
  }

  public function getPlugins() {
    // TODO: Implement getPlugins() method.
  }

  public function getTwig() {
    // TODO: Implement getTwig() method.
  }

  public function renderPattern(PatternInterface $pattern) {
    // TODO: Implement renderPattern() method.
  }
}