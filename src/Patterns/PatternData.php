<?php

namespace Labcoat\Patterns;

class PatternData implements PatternDataInterface {

  protected $file;

  public function __construct($file) {
    $this->file = $file;
  }

  public function getFile() {
    return $this->file;
  }
}