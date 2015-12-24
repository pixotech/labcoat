<?php

namespace Labcoat\Mocks\PatternLab\Patterns;

use Labcoat\PatternLab\Patterns\PseudoPatternInterface;

class PseudoPattern extends Pattern implements PseudoPatternInterface {

  public $pattern;
  public $variantName;

  public function __construct() {
    $this->pattern = new Pattern();
  }

  public function getPattern() {
    return $this->pattern;
  }

  public function getVariantName() {
    return $this->variantName;
  }
}