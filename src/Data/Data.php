<?php

namespace Labcoat\Data;

class Data implements DataInterface, \JsonSerializable {

  protected $data;

  public function __construct(array $data = []) {
    $this->data = $data;
  }

  public function jsonSerialize() {
    return $this->toArray();
  }

  public function merge(DataInterface $data) {
    $merged = clone $this;
    $merged->data = array_replace_recursive($merged->toArray(), $data->toArray());
    return $merged;
  }

  public function toArray() {
    return $this->data;
  }
}