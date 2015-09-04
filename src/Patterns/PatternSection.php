<?php

namespace Labcoat\Patterns;

use Labcoat\HasItemsTrait;

abstract class PatternSection implements \Countable, PatternSectionInterface {

  use HasItemsTrait;

  protected $time;

  abstract public function add(PatternInterface $pattern);

  /**
   * @return PatternInterface[]
   */
  abstract public function getAllPatterns();

  public function getTime() {
    if (!isset($this->time)) {
      $this->time = 0;
      foreach ($this->getAllPatterns() as $pattern) {
        $time = $pattern->getTime();
        if ($time > $this->time) $this->time = $time;
      }
    }
    return $this->time;
  }

  protected function addItem($key, $item) {
    $this->items[$key] = $item;
    ksort($this->items, SORT_NATURAL);
  }

  protected function addPattern(PatternInterface $pattern) {
    $this->addItem($pattern->getName(), $pattern);
  }
}