<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\PatternSubTypeInterface;

class PatternSubType implements PatternSubTypeInterface {

  public $name;

  public function getName() {
    return $this->name;
  }
}