<?php

namespace Labcoat\Mocks\PatternLab;

use Labcoat\PatternLab\PatternInterface;

class Pattern implements PatternInterface {

  /**
   * @var string
   */
  public $file;

  /**
   * @var string
   */
  public $id;

  /**
   * @var string
   */
  public $label;

  /**
   * @var string
   */
  public $name;

  /**
   * @var string
   */
  public $path;

  /**
   * @var string
   */
  public $type;

  /**
   * @return string
   */
  public function getFile() {
    return $this->file;
  }

  /**
   * @return string
   */
  public function getLabel() {
    return $this->label;
  }

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