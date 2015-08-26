<?php

namespace Labcoat\Patterns;

class PatternData implements PatternDataInterface {

  protected $file;

  public function __construct($file) {
    $this->file = $file;
  }

  public function getData() {
    return json_decode(file_get_contents($this->file), true);
  }

  public function getFile() {
    return $this->file;
  }
}