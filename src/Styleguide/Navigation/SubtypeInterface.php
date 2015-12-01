<?php

namespace Labcoat\Styleguide\Navigation;

interface SubtypeInterface {

  /**
   * @return string
   */
  public function getName();

  /**
   * @return string
   */
  public function getPartial();

  /**
   * @return PatternInterface[]
   */
  public function getPatterns();
}