<?php

namespace Labcoat\Data;

class Data implements \ArrayAccess, \IteratorAggregate, DataInterface {

  protected $data;

  public function __construct($json) {
    $this->data = (array)json_decode($json, true);
  }

  public function getIterator() {
    return new \ArrayIterator($this->data);
  }

  public function offsetExists($key) {
    return $this->offsetGet($key) !== null;
  }

  public function offsetGet($key) {
    $data = $this->data;
    foreach (explode('.', $key) as $k) {
      if (!isset($data[$k])) return null;
      $data = $data[$k];
    }
    return $data;
  }

  public function offsetSet($offset, $value) {
    throw new \BadMethodCallException("Read only");
  }

  public function offsetUnset($offset) {
    throw new \BadMethodCallException("Read only");
  }

  public function toArray() {
    return $this->data;
  }
}