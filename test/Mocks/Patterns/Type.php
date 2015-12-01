<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Structure\TypeInterface;

class Type implements TypeInterface {

  public $name;
  public $path;

  public function actsLikePattern() {
    return false;
  }

  public function actsLikeSection() {
    return true;
  }

  public function getNormalizedPath() {
    // TODO: Implement getNormalizedPath() method.
  }

  public function getPath() {
    return $this->path;
  }

  public function getSlug() {
    // TODO: Implement getSlug() method.
  }

  public function isPattern() {
    return false;
  }

  public function isPseudoPattern() {
    return false;
  }

  public function isSubtype() {
    return false;
  }

  public function isType() {
    return true;
  }

  public function addPattern(PatternInterface $pattern) {
    // TODO: Implement addPattern() method.
  }

  public function getId() {
    // TODO: Implement getId() method.
  }

  public function getName() {
    return $this->name;
  }

  public function hasSubtypes() {
    // TODO: Implement hasSubtypes() method.
  }
}