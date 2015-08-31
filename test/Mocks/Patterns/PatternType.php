<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\PatternTypeInterface;

class PatternType implements PatternTypeInterface {

  public $name;

  public function getName() {
    return $this->name;
  }
}