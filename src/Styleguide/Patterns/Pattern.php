<?php

namespace Labcoat\Styleguide\Patterns;

use Labcoat\Styleguide\StyleguideInterface;

class Pattern implements \JsonSerializable, PatternInterface {

  protected $pattern;
  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide, \Labcoat\Patterns\PatternInterface $pattern) {
    $this->styleguide = $styleguide;
    $this->pattern = $pattern;
  }

  public function jsonSerialize() {
    $data = [
      'cssEnabled' => false,
      'lineage' => $this->patternLineages(),
      'lineageR' => $this->patternLineagesR(),
      'patternBreadcrumb' => $this->getBreadcrumb(),
      'patternDesc' => $this->patternDesc(),
      'patternExtension' => $this->styleguide->getPatternLab()->getPatternExtension(),
      'patternName' => $this->patternName(),
      'patternPartial' => $this->patternPartial(),
      'patternState' => $this->pattern->getState(),
      'extraOutput' => [],
    ];
    return $data;
  }

  public function patternCSS() {
    return null;
  }

  public function patternCSSExists() {
    return false;
  }

  public function patternDesc() {

  }

  public function patternDescAdditions() {

  }

  public function patternDescExists() {

  }

  public function patternEngineName() {
    return "Twig";
  }

  public function patternExampleAdditions() {

  }

  public function patternLineageExists() {

  }

  public function patternLineageEExists() {

  }

  public function patternLineageRExists() {

  }

  public function patternLineages() {

  }

  public function patternLineagesR() {

  }

  public function patternLink() {

  }

  public function patternName() {

  }

  public function patternPartial() {

  }

  public function patternPartialCode() {

  }

  public function patternPartialCodeE() {

  }

  protected function getBreadcrumb() {
    $crumb = [$this->pattern->getType()];
    if ($this->pattern->hasSubtype()) $crumb[] = $this->pattern->getSubtype();
    return implode(' &gt; ', $crumb);
  }
}
