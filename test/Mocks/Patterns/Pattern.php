<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\PatternInterface;

class Pattern implements PatternInterface {

  public function actsLikePattern() {
    return true;
  }

  public function actsLikeSection() {
    return false;
  }

  public function getNormalizedPath() {
    // TODO: Implement getNormalizedPath() method.
  }

  public function getSlug() {
    // TODO: Implement getSlug() method.
  }

  public function isPattern() {
    return true;
  }

  public function isPseudoPattern() {
    return false;
  }

  public function isSubtype() {
    return false;
  }

  public function isType() {
    return false;
  }

  public function getData() {
    // TODO: Implement getData() method.
  }

  public function getFile() {
    // TODO: Implement getFile() method.
  }

  public function getId() {
    // TODO: Implement getId() method.
  }

  public function getIncludedPatterns() {
    // TODO: Implement getIncludedPatterns() method.
  }

  public function getName() {
    // TODO: Implement getName() method.
  }

  public function getPartial() {
    // TODO: Implement getPartial() method.
  }

  public function getPath() {
    // TODO: Implement getPath() method.
  }

  public function getPseudoPatterns() {
    // TODO: Implement getPseudoPatterns() method.
  }

  public function getState() {
    // TODO: Implement getState() method.
  }

  public function getTemplate() {
    // TODO: Implement getTemplate() method.
  }

  public function getTime() {
    // TODO: Implement getTime() method.
  }
}