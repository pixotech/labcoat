<?php

namespace Labcoat\Patterns\Paths;

class Path implements \Countable, PathInterface {

  const DELIMITER = '/';

  /**
   * @var SegmentInterface[]
   */
  protected $segments = [];

  public static function split($path) {
    return preg_split('|[\\\/]+|', $path, -1, PREG_SPLIT_NO_EMPTY);
  }

  public function __construct($path) {
    $this->makeSegments($path);
  }

  public function __toString() {
    return $this->join(self::DELIMITER);
  }

  public function count() {
    return count($this->segments);
  }

  /**
   * @return string
   */
  public function getPartial() {
    $name = $this->getName();
    $type = $this->hasType() ? $this->getType() : $name;
    return $type . '-' . $name;
  }

  /**
   * @return string
   */
  public function getPath() {
    return $this->__toString();
  }

  /**
   * @return string
   */
  public function getName() {
    return implode('-', array_slice($this->segments, $this->getNameSegmentIndex()));
  }

  /**
   * @return string|null
   */
  public function getSubtype() {
    return $this->hasSubtype() ? (string)$this->segments[1] : null;
  }

  /**
   * @return string|null
   */
  public function getType() {
    return $this->hasType() ? (string)$this->segments[0] : null;
  }

  public function hasSubtype() {
    return $this->count() > 2;
  }

  public function hasType() {
    return $this->count() > 1;
  }

  public function join($delimiter) {
    return implode($delimiter, $this->segments);
  }

  public function normalize() {
    $normalized = clone $this;
    foreach ($normalized->segments as $i => $segment) {
      $normalized->segments[$i] = $segment->normalize();
    }
    return $normalized;
  }

  protected function getNameSegmentIndex() {
    if ($this->hasSubtype()) return 2;
    elseif ($this->hasType()) return 1;
    return 0;
  }

  protected function makeSegments($path) {
    foreach (self::split($path) as $segment) {
      $this->segments[] = new Segment($segment);
    }
  }
}