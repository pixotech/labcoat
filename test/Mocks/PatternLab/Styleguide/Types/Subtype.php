<?php

namespace Labcoat\Mocks\PatternLab\Styleguide\Types;

use Labcoat\PatternLab\Styleguide\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\Types\SubtypeInterface;

class Subtype implements SubtypeInterface {

  public $id;
  public $label;
  public $name;
  public $partial;
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

  public function getPartial() {
    return $this->partial;
  }

  public function getPatterns() {
    return $this->patterns;
  }

  public function getType() {
    return $this->type;
  }

  public function getId() {
    return $this->id;
  }

  public function getLabel() {
    return $this->label;
  }

  public function getPagePath() {
    // TODO: Implement getPagePath() method.
  }

  public function getSubtypes() {
    // TODO: Implement getSubtypes() method.
  }

  public function hasSubtypes() {
    // TODO: Implement hasSubtypes() method.
  }
}