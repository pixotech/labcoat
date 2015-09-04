<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Patterns\SubtypeInterface;
use RecursiveIterator;

class Subtype implements SubtypeInterface {

  public $name;
  public $type;

  public function getName() {
    return $this->name;
  }

  public function getType() {
    return $this->type;
  }

  public function getId() {
    // TODO: Implement getId() method.
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