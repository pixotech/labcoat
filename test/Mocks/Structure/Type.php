<?php

namespace Labcoat\Mocks\Structure;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Structure\SubtypeInterface;
use Labcoat\Structure\TypeInterface;

class Type implements TypeInterface {

  public $name;
  public $path;
  public $patterns = [];
  public $subtypes = [];

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

  public function hasSubtypes() {
    // TODO: Implement hasSubtypes() method.
  }

  public function getSubtypes() {
    return $this->subtypes;
  }
}