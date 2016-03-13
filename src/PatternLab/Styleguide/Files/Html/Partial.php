<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html;

use Labcoat\PatternLab\Patterns\PatternInterface;

class Partial implements PartialInterface {

  protected $pattern;

  public function __construct(PatternInterface $pattern) {
    $this->pattern = $pattern;
  }

  public function getLineage() {
    return [
      'lineagePattern' => $this->getPatternPartial(),
      'lineagePath' => "../../{$this->getPatternUrl()}",
    ];
  }

  public function getPattern() {
    return $this->pattern;
  }

  public function getPatternDescription() {
    return $this->getPattern()->getDescription();
  }

  public function getPatternExample() {
    return $this->getPattern()->getExample();
  }

  public function getPatternLineage() {
    return $this->makePatternLineage();
  }

  public function getPatternName() {
    return $this->getPattern()->getLabel();
  }

  public function getPatternPartial() {
    return $this->getPattern()->getPartial();
  }

  public function getPatternReverseLineage() {
    return $this->makeReversePatternLineage();
  }

  public function getPatternUrl() {
    $dir = $this->getPattern()->getStyleguideDirectoryName();
    return "$dir/$dir.html";
  }

  public function hasPatternDescription() {
    return (bool)$this->getPattern()->getDescription();
  }

  public function jsonSerialize() {
    return [
      'patternPartial' => $this->getPatternPartial(),
      'patternName' => $this->getPatternName(),
      'patternDescExists' => $this->hasPatternDescription(),
      'patternDesc' => $this->getPatternDescription(),
      'patternDescAdditions' => [],
      'patternPartialCode' => $this->getPatternExample(),
      'patternLink' => $this->getPatternUrl(),
      'patternLineages' => $this->getPatternLineage(),
      'patternLineagesR' => $this->getPatternReverseLineage(),
      'patternEngineName' => 'Twig',
    ];
  }

  public function makePatternLineage() {
    $lineage = [];
    foreach ($this->getPattern()->getIncludedPatterns() as $pattern) {
      $lineage[] = (new Partial($pattern))->getLineage();
    }
    return $lineage;
  }

  public function makeReversePatternLineage() {
    $lineage = [];
    foreach ($this->getPattern()->getIncludingPatterns() as $pattern) {
      $lineage[] = (new Partial($pattern))->getLineage();
    }
    return $lineage;
  }
}