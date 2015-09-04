<?php

namespace Labcoat;

trait HasItemsTrait {

  protected $items = [];
  protected $iteratorPosition = 0;

  public function count() {
    return count($this->items);
  }

  /**
   * @return mixed
   */
  public function current() {
    return $this->items[$this->getIteratorKey()];
  }

  public function getChildren() {
    return $this->current();
  }

  public function hasChildren() {
    return ($this->current() instanceof HasItemsInterface) ? ($this->current()->count() > 0) : false;
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