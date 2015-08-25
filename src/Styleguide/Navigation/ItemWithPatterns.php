<?php

namespace Labcoat\Styleguide\Navigation;

abstract class ItemWithPatterns {

  /**
   * @return \Labcoat\Patterns\Pattern
   */
  abstract protected function getPatterns();

  protected function getItems() {
    $patterns = [];
    foreach ($this->getPatterns() as $pattern) {
      $patterns[] = new Pattern($pattern);
      foreach (array_keys($pattern->getPseudoPatterns()) as $pseudoPattern) {
        $patterns[] = new PseudoPattern($pattern, $pseudoPattern);
      }
    }
    return $patterns;
  }
}