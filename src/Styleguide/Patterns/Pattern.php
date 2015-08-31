<?php

namespace Labcoat\Styleguide\Patterns;

use Labcoat\Patterns\PatternInterface as SourcePatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

class Pattern implements \JsonSerializable, PatternInterface {

  protected $pattern;
  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide, SourcePatternInterface $pattern) {
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
      'patternExtension' => 'twig',
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
    return "";
  }

  public function patternDescAdditions() {
    return [];
  }

  public function patternDescExists() {
    return false;
  }

  public function patternEngineName() {
    return "Twig";
  }

  public function patternExampleAdditions() {
    return [];
  }

  public function patternLineageExists() {
    return false;
  }

  public function patternLineageEExists() {
    return false;
  }

  public function patternLineageRExists() {
    return false;
  }

  public function patternLineages() {
    return [];
  }

  public function patternLineagesR() {
    return [];
  }

  public function patternLink() {
    $nav = new \Labcoat\Styleguide\Navigation\Pattern($this->pattern);
    return $nav->getPath();
  }

  public function patternName() {
    return ucwords(str_replace('-', ' ', $this->pattern->getName()));
  }

  public function patternPartial() {
    return $this->pattern->getPartial();
  }

  public function patternPartialCode() {
    $path = $this->pattern->getPath();
    $data = $this->pattern->getData();
    return $this->styleguide->getPatternLab()->render($path, $data);
  }

  public function patternPartialCodeE() {
    return '';
  }

  public function patternSectionSubtype() {
    return false;
  }

  protected function getBreadcrumb() {
    $crumb = [$this->pattern->getType()];
    if ($this->pattern->hasSubType()) $crumb[] = $this->pattern->getSubType();
    return implode(' &gt; ', $crumb);
  }
}
