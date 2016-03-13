<?php

namespace Labcoat\PatternLab\Patterns\Types;

interface SubtypeInterface extends TypeInterface {

  /**
   * @return TypeInterface
   */
  public function getType();
}