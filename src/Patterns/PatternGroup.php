<?php

namespace Labcoat\Patterns;

abstract class PatternGroup implements \Countable, \RecursiveIterator {

  protected $items = [];
  protected $iteratorPosition = 0;

  abstract public function add(PatternInterface $pattern);

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
    if (!($this->current() instanceof PatternGroup)) return false;
    return count($this->current()) > 0;
  }

  public function key() {
    return Pattern::stripOrdering($this->getIteratorKey());
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

  protected function addItem($key, $item) {
    $this->items[$key] = $item;
    ksort($this->items, SORT_NATURAL);
  }

  protected function addPattern(PatternInterface $pattern) {
    $this->addItem($pattern->getName(), $pattern);
  }

  protected function getIteratorKey() {
    return array_keys($this->items)[$this->iteratorPosition];
  }
}