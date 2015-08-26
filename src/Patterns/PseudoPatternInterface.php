<?php

namespace Labcoat\Patterns;

interface PseudoPatternInterface extends PatternInterface {

  /**
   * @return PatternInterface
   */
  public function getPattern();

  /**
   * @return string
   */
  public function getVariantName();
}