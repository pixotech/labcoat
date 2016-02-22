<?php

namespace Labcoat\Mocks\PatternLab;

use Labcoat\PatternLab\PatternInterface;

class Pattern implements PatternInterface {

  public $file;
  public $id;
  public $name;
  public $path;
  public $type;

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * @return string
   */
  public function getType() {
    return $this->type;
  }
}