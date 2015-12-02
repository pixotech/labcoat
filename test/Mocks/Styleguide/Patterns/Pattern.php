<?php

namespace Labcoat\Mocks\Styleguide\Patterns;

use Labcoat\Styleguide\Patterns\PatternInterface;

class Pattern implements PatternInterface {

  public $lineagePath;
  public $partial;

  public function addIncludedPattern(PatternInterface $pattern) {
    // TODO: Implement addIncludedPattern() method.
  }

  public function addIncludingPattern(PatternInterface $pattern) {
    // TODO: Implement addIncludingPattern() method.
  }

  public function getBreadcrumb() {
    // TODO: Implement getBreadcrumb() method.
  }

  public function getContent() {
    // TODO: Implement getContent() method.
  }

  public function getData() {
    // TODO: Implement getData() method.
  }

  public function getEscapedSourcePath() {
    // TODO: Implement getEscapedSourcePath() method.
  }

  public function getId() {
    // TODO: Implement getId() method.
  }

  public function getIncludedPatterns() {
    // TODO: Implement getIncludedPatterns() method.
  }

  public function getName() {
    // TODO: Implement getName() method.
  }

  public function getFile() {
    // TODO: Implement getFile() method.
  }

  public function getLineagePath() {
    return $this->lineagePath;
  }

  public function getPagePath() {
    // TODO: Implement getPagePath() method.
  }

  public function getPartial() {
    return $this->partial;
  }

  public function getPath() {
    // TODO: Implement getPath() method.
  }

  public function getSourcePath() {
    // TODO: Implement getSourcePath() method.
  }

  public function getTemplate() {
    // TODO: Implement getTemplate() method.
  }

  public function getTemplatePath() {
    // TODO: Implement getTemplatePath() method.
  }

  public function getTime() {
    // TODO: Implement getTime() method.
  }

  public function patternCSS() {
    // TODO: Implement patternCSS() method.
  }

  public function patternCSSExists() {
    // TODO: Implement patternCSSExists() method.
  }

  public function getDescription() {
    // TODO: Implement patternDesc() method.
  }

  public function patternDescAdditions() {
    // TODO: Implement patternDescAdditions() method.
  }

  public function patternDescExists() {
    // TODO: Implement patternDescExists() method.
  }

  public function patternEngineName() {
    // TODO: Implement patternEngineName() method.
  }

  public function patternExampleAdditions() {
    // TODO: Implement patternExampleAdditions() method.
  }

  public function patternLineageExists() {
    // TODO: Implement patternLineageExists() method.
  }

  public function patternLineageEExists() {
    // TODO: Implement patternLineageEExists() method.
  }

  public function patternLineageRExists() {
    // TODO: Implement patternLineageRExists() method.
  }

  public function patternLineages() {
    // TODO: Implement patternLineages() method.
  }

  public function patternLineagesR() {
    // TODO: Implement patternLineagesR() method.
  }

  public function patternLink() {
    // TODO: Implement patternLink() method.
  }

  public function patternName() {
    // TODO: Implement patternName() method.
  }

  public function patternPartial() {
    // TODO: Implement patternPartial() method.
  }

  public function patternPartialCode() {
    // TODO: Implement patternPartialCode() method.
  }

  public function patternPartialCodeE() {
    // TODO: Implement patternPartialCodeE() method.
  }

  public function patternSectionSubtype() {
    // TODO: Implement patternSectionSubtype() method.
  }


}