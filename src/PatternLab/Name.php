<?php

namespace Labcoat\PatternLab;

class Name implements NameInterface {

  /**
   * @var string
   */
  protected $name;

  /**
   * @var int
   */
  protected $ordering;

  public static function cmp(NameInterface $name1, NameInterface $name2) {
    if ($name1->hasOrdering() and $name2->hasOrdering()) {
      $order1 = (int)$name1->getOrdering();
      $order2 = (int)$name2->getOrdering();
      if ($order1 <> $order2) return $order1 < $order2 ? -1 : 1;
    }
    elseif ($name1->hasOrdering()) {
      return -1;
    }
    elseif ($name2->hasOrdering()) {
      return 1;
    }
    return strcasecmp((string)$name1, (string)$name2);
  }

  /**
   * @param string $name
   */
  public function __construct($name) {
    list($ordering, $ordered) = array_pad(explode('-', $name, 2), 2, NULL);
    if (is_numeric($ordering)) {
      $this->ordering = (int)$ordering;
      $name = $ordered;
    }
    $this->name = $name;
  }

  public function __toString() {
    return $this->name;
  }

  public function capitalized() {
    return ucwords($this->join(' '));
  }

  /**
   * @return int|null
   */
  public function getOrdering() {
    return $this->ordering;
  }

  public function hasOrdering() {
    return !isset($this->ordering);
  }

  public function join($delimiter) {
    return implode($delimiter, $this->words());
  }

  public function lowercase() {
    return strtolower($this->join(' '));
  }

  public function words() {
    return preg_split('/-+/', $this->name, -1, PREG_SPLIT_NO_EMPTY);
  }
}