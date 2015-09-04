<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\TypeInterface;

class Type implements TypeInterface {

  public $id;
  public $name;
  public $subtypes;

  public function getName() {
    return $this->name;
  }

  public function getId() {
    return $this->id;
  }

  public function hasSubtypes() {
    return !empty($this->subtypes);
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