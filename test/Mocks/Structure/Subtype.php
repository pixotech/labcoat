<?php

namespace Labcoat\Mocks\Structure;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Structure\SubtypeInterface;

class Subtype implements SubtypeInterface {

  public $name;
  public $patterns = [];
  public $type;

  public function addPattern(PatternInterface $pattern) {
    // TODO: Implement addPattern() method.
  }

  public function addPatterns(array $patterns) {
    // TODO: Implement addPatterns() method.
  }

  public function getName() {
    return $this->name;
  }

  public function getPatterns() {
    return $this->patterns;
  }

  public function getType() {
    return $this->type;
  }
}