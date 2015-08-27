<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\PatternLab;

class PseudoPattern extends Pattern {

  protected $pseudoPattern;

  public function __construct(\Labcoat\Patterns\Pattern $pattern, $pseudoPattern) {
    parent::__construct($pattern);
    $this->pseudoPattern = $pseudoPattern;
  }

  public function getName() {
    $name = PatternLab::stripOrdering($this->pattern->getName()) . '-' . $this->pseudoPattern;
    return ucwords(str_replace('-', ' ', $name));
  }

  public function getPartial() {
    return $this->pattern->getPartial() . '-' . $this->pseudoPattern;
  }

  public function getPatternPath() {
    $parts = explode('/', $this->getSourcePath());
    $parts[] = $this->pseudoPattern;
    $path = implode('-', $parts);
    return $path . DIRECTORY_SEPARATOR . $path . ".html";
  }

  public function getSourcePath() {
    return $this->pattern->getPath() . '-' . $this->pseudoPattern;
  }
}