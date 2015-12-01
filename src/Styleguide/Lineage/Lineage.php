<?php

namespace Labcoat\Styleguide\Lineage;

use Labcoat\Styleguide\Patterns\PatternInterface;

class Lineage implements LineageInterface, \JsonSerializable {

  protected $patterns = [];

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = new LineagePattern($pattern);
  }

  public function getPatterns() {
    return $this->patterns;
  }

  function jsonSerialize() {
    return $this->patterns;
  }
}