<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\PatternInterface;

class Pattern implements PatternInterface {

  public $name;
  public $path;
  public $partial;
  public $state;

  public function getData() {
    // TODO: Implement getData() method.
  }

  public function getFile() {
    // TODO: Implement getFile() method.
  }

  public function getId() {
    // TODO: Implement getId() method.
  }

  public function getName() {
    return $this->name;
  }

  public function getPartial() {
    return $this->partial;
  }

  public function getPath() {
    return $this->path;
  }

  public function getState() {
    return $this->state;
  }

  public function getSubType() {
    // TODO: Implement getSubType() method.
  }

  public function getTime() {
    // TODO: Implement getTime() method.
  }

  public function getTemplate() {
    // TODO: Implement getTemplate() method.
  }

  public function getTemplateContent() {
    // TODO: Implement getTemplateContent() method.
  }

  public function getType() {
    // TODO: Implement getType() method.
  }

  public function hasSubType() {
    // TODO: Implement hasSubType() method.
  }
}