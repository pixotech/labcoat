<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\PatternInterface;

class Pattern implements PatternInterface {

  public $displayName;
  public $example;
  public $file;
  public $name;
  public $partial;
  public $path;
  public $state;
  public $styleguidePathName;
  public $subType;
  public $type;

  public function getData() {
    // TODO: Implement getData() method.
  }

  public function getDisplayName() {
    return $this->displayName;
  }

  public function getFile() {
    return $this->file;
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

  public function getStyleguidePathName() {
    return $this->styleguidePathName;
  }

  public function getSubType() {
    return $this->subType;
  }

  public function getTime() {
    // TODO: Implement getTime() method.
  }

  public function getTemplateContent() {
    // TODO: Implement getTemplateContent() method.
  }

  public function getType() {
    return $this->type;
  }

  public function hasSubType() {
    return !empty($this->subType);
  }

  public function getLowercaseName() {
    // TODO: Implement getLowercaseName() method.
  }

  public function getNameWithoutDigits() {
    // TODO: Implement getNameWithoutDigits() method.
  }

  public function getUppercaseName() {
    // TODO: Implement getUppercaseName() method.
  }
}