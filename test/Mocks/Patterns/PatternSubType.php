<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\PatternSubTypeInterface;

class PatternSubType implements PatternSubTypeInterface {

  public $name;
  public $type;

  public function getName() {
    return $this->name;
  }

  public function getType() {
    return $this->type;
  }
}