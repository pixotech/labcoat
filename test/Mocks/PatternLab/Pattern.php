<?php

namespace Labcoat\Mocks\PatternLab;

use Labcoat\PatternLab\PatternInterface;

class Pattern implements PatternInterface {

  /**
   * @var array
   */
  public $data = [];

  /**
   * @var string
   */
  public $description;

  /**
   * @var string
   */
  public $file;

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
  public $state;

  /**
   * @var string
   */
  public $subtype;

  /**
   * @var string
   */
  public $type;

  /**
   * @return array
   */
  public function getData() {
    return $this->data;
  }

  public function getDescription() {
    return $this->description;
  }

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
  public function getState() {
    return $this->state;
  }

  /**
   * @return string
   */
  public function getSubtype() {
    return $this->subtype;
  }

  /**
   * @return string
   */
  public function getType() {
    return $this->type;
  }

  /**
   * @return bool
   */
  public function hasSubtype() {
    return !empty($this->subtype);
  }
}