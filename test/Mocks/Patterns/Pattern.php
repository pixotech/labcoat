<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PseudoPatternInterface;
use RecursiveIterator;

class Pattern implements PatternInterface {

  public $data = [];
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
    return $this->data;
  }

  public function getFile() {
    return $this->file;
  }

  public function getId() {
    return $this->id;
  }

  public function getIncludedPatterns() {
    // TODO: Implement getIncludedPatterns() method.
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

  public function current() {
    // TODO: Implement current() method.
  }

  public function next() {
    // TODO: Implement next() method.
  }

  public function key() {
    // TODO: Implement key() method.
  }

  public function valid() {
    // TODO: Implement valid() method.
  }

  public function rewind() {
    // TODO: Implement rewind() method.
  }

  public function count() {
    // TODO: Implement count() method.
  }

  public function hasChildren() {
    // TODO: Implement hasChildren() method.
  }

  public function getChildren() {
    // TODO: Implement getChildren() method.
  }
}