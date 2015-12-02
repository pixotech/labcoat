<?php

namespace Labcoat\Patterns\Paths;

class Name implements NameInterface {

  protected $name;

  public function __construct($name) {
    $this->name = $name;
  }

  public function __toString() {
    return (string)$this->name;
  }
}