<?php

namespace Labcoat\Mocks\PatternLab\Styleguide;

use Labcoat\PatternLab\Styleguide\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\Files\Html\PageInterface;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

class Styleguide implements StyleguideInterface {

  public $globalData = [];
  public $hiddenControls = [];
  public $patternlab;
  public $patterns = [];
  public $rendered = [];
  public $renders = [];
  public $types = [];

  public function addPattern(\Labcoat\PatternLab\Patterns\PatternInterface $pattern) {
    $this->patterns[] = $pattern;
  }

  public function getGlobalData() {
    return $this->globalData;
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

  public function getPattern($id) {
    return $this->patterns[$id];
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

  public function getMaximumWidth() {
    // TODO: Implement getMaximumWidth() method.
  }

  public function getMinimumWidth() {
    // TODO: Implement getMinimumWidth() method.
  }

  public function render($template, array $data = []) {
    $this->renders[] = [$template, $data];
    return $this->rendered[$template];
  }

  public function renderPage(PageInterface $page) {
    // TODO: Implement renderPage() method.
  }

  public function getPatternFooterTemplatePath() {
    // TODO: Implement getPatternFooterTemplatePath() method.
  }

  public function getPatternHeaderTemplatePath() {
    // TODO: Implement getPatternHeaderTemplatePath() method.
  }

  public function setPatternFooterTemplatePath($path) {
    // TODO: Implement setPatternFooterTemplatePath() method.
  }

  public function setPatternHeaderTemplatePath($path) {
    // TODO: Implement setPatternHeaderTemplatePath() method.
  }

  public function getAnnotationsFilePath() {
    // TODO: Implement getAnnotationsFilePath() method.
  }

  public function setAnnotationsFilePath($path) {
    // TODO: Implement setAnnotationsFilePath() method.
  }

  public function setGlobalData($data) {
    // TODO: Implement setGlobalData() method.
  }

  public function getHiddenControls() {
    return $this->hiddenControls;
  }

  public function setHiddenControls(array $controls) {
    $this->hiddenControls = $controls;
  }

  /**
   * @return array
   */
  public function getTypes() {
    return $this->types;
  }
}