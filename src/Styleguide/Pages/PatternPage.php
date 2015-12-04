<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

class PatternPage extends Page implements PatternPageInterface {

  protected $pattern;

  public static function makeLineage($pattern) {
    return [
      'lineagePattern' => $pattern->getPartial(),
      'lineagePath' => $pattern->getLineagePath(),
    ];
  }

  public static function makePatternData($pattern) {
    $data = [
      'patternExtension' => 'twig',
      'cssEnabled' => false,
      'extraOutput' => [],
      'patternName' => $pattern->getName(),
      'patternPartial' => $pattern->getPartial(),
      'patternState' => $pattern->getState(),
      'patternDesc' => $pattern->getDescription(),
      'lineage' => self::makePatternLineage($pattern),
      'lineageR' => self::makeReversePatternLineage($pattern),
    ];
    return $data;
  }

  public static function makePatternLineage($pattern) {
    $lineage = [];
    foreach ($pattern->getIncludedPatterns() as $pattern2) {
      $lineage[] = self::makeLineage($pattern2);
    }
    return $lineage;
  }

  public static function makeReversePatternLineage($pattern) {
    $lineage = [];
    foreach ($pattern->getIncludingPatterns() as $pattern2) {
      $lineage[] = self::makeLineage($pattern2);
    }
    return $lineage;
  }

  public function __construct(PatternInterface $pattern) {
    $this->pattern = $pattern;
  }

  public function getContent(StyleguideInterface $styleguide) {
    return $this->pattern->getContent();
  }

  public function getFooterVariables(StyleguideInterface $styleguide) {
    return $this->pattern->getData();
  }

  public function getHeaderVariables(StyleguideInterface $styleguide) {
    return $this->pattern->getData();
  }

  public function getPath() {
    return $this->pattern->getPagePath();
  }

  public function getPattern() {
    return $this->pattern;
  }

  public function getPatternData() {
    return self::makePatternData($this->pattern);
  }

  public function getTime() {
    return $this->pattern->getTime();
  }
}