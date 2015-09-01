<?php

namespace Labcoat\Patterns;

interface PatternTypeInterface {

  /**
   * @return string
   */
  public function getId();

  /**
   * @return string
   */
  public function getName();
}