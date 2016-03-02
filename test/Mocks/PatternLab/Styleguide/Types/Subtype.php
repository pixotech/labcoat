<?php

namespace Labcoat\Mocks\PatternLab\Styleguide\Types;

use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\Types\SubtypeInterface;

class Subtype implements SubtypeInterface {

  public $label;
  public $name;
  public $partial;
  public $patterns = [];
  public $styleguideDirectoryName;
  public $type;

  public function addPattern(PatternInterface $pattern) {
    // TODO: Implement addPattern() method.
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

  public function getLabel() {
    return $this->label;
  }

  public function getStyleguideDirectoryName() {
    return $this->styleguideDirectoryName;
  }

  public function getSubtypes() {
    // TODO: Implement getSubtypes() method.
  }

  public function hasSubtypes() {
    // TODO: Implement hasSubtypes() method.
  }
}