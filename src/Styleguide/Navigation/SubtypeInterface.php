<?php

namespace Labcoat\Styleguide\Navigation;

interface SubtypeInterface {

  /**
   * @return PatternInterface[]
   */
  public function getPatterns();
}