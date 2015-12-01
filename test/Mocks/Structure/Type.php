<?php

namespace Labcoat\Mocks\Structure;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Structure\TypeInterface;

class Type implements TypeInterface {

  public $name;
  public $path;

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
    // TODO: Implement getPatterns() method.
  }

  public function hasSubtypes() {
    // TODO: Implement hasSubtypes() method.
  }
}