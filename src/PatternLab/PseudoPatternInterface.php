<?php

namespace Labcoat\PatternLab;

interface PseudoPatternInterface {

  /**
   * @return array
   */
  public function getData();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return PatternInterface
   */
  public function getPattern();
}