<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Sections\TypeInterface;

class Type implements TypeInterface {

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
    // TODO: Implement getPath() method.
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
    // TODO: Implement getName() method.
  }

  public function hasSubtypes() {
    // TODO: Implement hasSubtypes() method.
  }
}