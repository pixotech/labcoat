<?php

namespace Labcoat\Patterns;

interface PatternSubTypeInterface {

  /**
   * @return string
   */
  public function getName();

  /**
   * @return PatternTypeInterface
   */
  public function getType();
}