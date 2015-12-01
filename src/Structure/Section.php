<?php

namespace Labcoat\Structure;

use Labcoat\HasItemsInterface;
use Labcoat\HasItemsTrait;
use Labcoat\Item;
use Labcoat\Patterns\PatternInterface;

abstract class Section extends Item implements \Countable, HasItemsInterface, SectionInterface {

  use HasItemsTrait;

  protected $time;

  public function addPattern(PatternInterface $pattern) {
    $this->items[$pattern->getSlug()] = $pattern;
  }

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
}