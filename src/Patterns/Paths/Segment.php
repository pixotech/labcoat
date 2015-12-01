<?php

namespace Labcoat\Patterns\Paths;

class Segment implements SegmentInterface {

  /**
   * @var string
   */
  protected $name;

  /**
   * @var string
   */
  protected $ordering;

  /**
   * Remove ordering digits from a path segment
   *
   * @param string $str A path segment
   * @return string The path without any ordering digits
   */
  public static function stripDigits($str) {
    list($num, $name) = array_pad(explode('-', $str, 2), 2, NULL);
    return is_numeric($num) ? $name : $str;
  }

  /**
   * @param string $segment
   */
  public function __construct($segment) {
    $this->name = $segment;
    list($ordering, $name) = array_pad(explode('-', $segment, 2), 2, NULL);
    if (is_numeric($ordering)) {
      $this->ordering = $ordering;
      $this->name = $name;
    }
  }

  public function __toString() {
    return $this->hasOrdering() ? "{$this->ordering}-{$this->name}" : $this->name;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getOrdering() {
    return $this->ordering;
  }

  public function hasOrdering() {
    return !empty($this->ordering);
  }
}