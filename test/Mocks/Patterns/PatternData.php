<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\PatternDataInterface;

class PatternData implements PatternDataInterface {

  public $data;
  public $file;

  public function getData() {
    return $this->data;
  }

  public function getFile() {
    return $this->file;
  }
}