<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\Patterns;

use Labcoat\Generator\Paths\Path;
use Labcoat\PatternLab\Styleguide\Files\Html\PageRendererInterface;
use Labcoat\PatternLab\Styleguide\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\Files\Html\Page;

class PatternPage extends Page implements PatternPageInterface {

  /**
   * @var PatternInterface
   */
  protected $pattern;

  public static function makeData(PatternInterface $pattern) {
    $data = [
      'patternExtension' => 'twig',
      'cssEnabled' => false,
      'extraOutput' => [],
      'patternName' => $pattern->getLabel(),
      'patternPartial' => $pattern->getPartial(),
      'patternState' => $pattern->hasState() ? $pattern->getState() : '',
      'patternStateExists' => $pattern->hasState(),
      'patternDesc' => $pattern->getDescription(),
      'patternDescExists' => (bool)$pattern->getDescription(),
      'lineage' => self::makePatternLineage($pattern),
      'lineageR' => self::makeReversePatternLineage($pattern),
    ];
    return $data;
  }

  public static function makeLineage(PatternInterface $pattern) {
    $id = $pattern->getId();
    return [
      'lineagePattern' => $pattern->getPartial(),
      'lineagePath' => "../../{$id}/{$id}.html",
    ];
  }

  public static function makePatternLineage(PatternInterface $pattern) {
    $lineage = [];
    foreach ($pattern->getIncludedPatterns() as $pattern2) {
      $lineage[] = self::makeLineage($pattern2);
    }
    return $lineage;
  }

  public static function makeReversePatternLineage(PatternInterface $pattern) {
    $lineage = [];
    foreach ($pattern->getIncludingPatterns() as $pattern2) {
      $lineage[] = self::makeLineage($pattern2);
    }
    return $lineage;
  }

  public function __construct(PageRendererInterface $renderer, PatternInterface $pattern) {
    parent::__construct($renderer);
    $this->pattern = $pattern;
  }

  public function getContent() {
    return $this->pattern->getExample();
  }

  public function getData() {
    return self::makeData($this->pattern);
  }

  public function getPath() {
    $path = $this->pattern->getId();
    return new Path("patterns/$path/$path.html");
  }

  public function getPattern() {
    return $this->pattern;
  }

  public function getTime() {
    return $this->pattern->getTime();
  }
}