<?php

namespace Labcoat\Mocks\PatternLab\Styleguide\Types;

use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\Types\TypeInterface;

class Type implements TypeInterface {

  public $id;
  public $label;
  public $name;
  public $partial;
  public $path;
  public $patterns = [];
  public $subtypes = [];

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
  }

  public function addPatterns(array $patterns) {
    foreach ($patterns as $pattern) $this->addPattern($pattern);
  }

  public function getName() {
    return $this->name;
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

  public function getId() {
    return $this->id;
  }

  public function getLabel() {
    return $this->label;
  }

  public function getPartial() {
    return $this->partial;
  }
}