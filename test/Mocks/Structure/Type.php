<?php

namespace Labcoat\Mocks\Structure;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Structure\TypeInterface;

class Type implements TypeInterface {

  public $name;
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
    // TODO: Implement getId() method.
  }

  public function getLabel() {
    // TODO: Implement getLabel() method.
  }

  public function getPagePath() {
    // TODO: Implement getPagePath() method.
  }
}