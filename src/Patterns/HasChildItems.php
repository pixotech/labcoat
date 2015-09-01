<?php

namespace Labcoat\Patterns;

use Labcoat\PatternLab;

trait HasChildItems {

  protected $items = [];
  protected $iteratorPosition = 0;

  public function count() {
    return count($this->items);
  }

  public function current() {
    return $this->items[$this->getIteratorKey()];
  }

  public function getChildren() {
    return $this->current();
  }

  public function hasChildren() {
    print_r($this->current());
    if (!($this->current() instanceof \RecursiveIterator)) return false;
    return count($this->current()) > 0;
  }

  public function key() {
    return PatternLab::stripDigits($this->getIteratorKey());
  }

  public function next() {
    ++$this->iteratorPosition;
  }

  public function rewind() {
    $this->iteratorPosition = 0;
  }

  public function valid() {
    return $this->iteratorPosition < $this->count();
  }

  protected function getIteratorKey() {
    return array_keys($this->items)[$this->iteratorPosition];
  }
}