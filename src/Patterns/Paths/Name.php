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

  public function capitalized() {
    return ucwords(implode(' ', $this->words()));
  }

  public function lowercase() {
    return strtolower(implode(' ', $this->words()));
  }

  public function words() {
    return preg_split('/-+/', (string)$this, -1, PREG_SPLIT_NO_EMPTY);
  }
}