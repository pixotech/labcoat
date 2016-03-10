<?php

namespace Labcoat\Mocks\PatternLab\Styleguide\Types;

use Labcoat\PatternLab\PatternLab;
use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\Types\TypeInterface;

class Type implements TypeInterface {

  public $label;
  public $name;
  public $partial;
  public $patterns = [];
  public $styleguideDirectoryPath;
  public $subtypes = [];

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
  }

  public function getName() {
    return $this->name;
  }

  public function getNameWithoutOrdering() {
    return PatternLab::stripOrdering($this->getName());
  }

  public function getPatterns() {
    return $this->patterns;
  }

  public function hasSubtypes() {
    return !empty($this->subtypes);
  }

  public function getSubtypes() {
    return $this->subtypes;
  }

  public function getLabel() {
    return $this->label;
  }

  public function getPartial() {
    return $this->partial;
  }

  public function getStyleguideDirectoryName() {
    return $this->getName();
  }
}