<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\PatternTypeInterface;

class PatternType implements PatternTypeInterface {

  public $id;
  public $name;
  public $subtypes;

  public function getName() {
    return $this->name;
  }

  public function getId() {
    return $this->id;
  }

  public function hasSubtypes() {
    return !empty($this->subtypes);
  }
}