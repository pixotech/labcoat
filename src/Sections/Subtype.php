<?php

namespace Labcoat\Sections;

use Labcoat\Patterns\PatternInterface;

class Subtype extends Section implements SubtypeInterface {

  public function __construct($path) {
    $this->path = $path;
    $this->id = $path;
  }

  public function getAllPatterns() {
    return $this->getPatterns();
  }

  /**
   * @return PatternInterface[]
   */
  public function getPatterns() {
    return $this->items;
  }
}