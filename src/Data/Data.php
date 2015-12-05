<?php

namespace Labcoat\Data;

class Data implements DataInterface, \JsonSerializable {

  protected $data;

  public static function load($file) {
    return static::parse(file_get_contents($file));
  }

  public static function parse($string) {
    return new static(json_decode($string, true));
  }

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