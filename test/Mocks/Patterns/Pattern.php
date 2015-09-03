<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PseudoPatternInterface;

class Pattern implements PatternInterface {

  public $file;
  public $id;
  public $name;
  public $path;
  public $partial;
  public $state;
  public $subtype;
  public $template;
  public $type;

  public function getData() {
    // TODO: Implement getData() method.
  }

  public function getFile() {
    return $this->file;
  }

  public function getId() {
    return $this->id;
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

  public function getPseudoPatterns() {
    // TODO: Implement getPseudoPatterns() method.
  }

  public function getState() {
    return $this->state;
  }

  public function getSubType() {
    return $this->subtype;
  }

  public function getTime() {
    // TODO: Implement getTime() method.
  }

  public function getTemplate() {
    return $this->template;
  }

  public function getTemplateContent() {
    // TODO: Implement getTemplateContent() method.
  }

  public function getType() {
    return $this->type;
  }

  public function hasSubType() {
    return !empty($this->subtype);
  }

  public function getSubTypeId() {
    // TODO: Implement getSubTypeId() method.
  }

  public function getTypeId() {
    // TODO: Implement getTypeId() method.
  }
}