<?php

namespace Labcoat\Paths;

class Path implements \Countable, PathInterface {

  const DELIMITER = '/';

  /**
   * @var SegmentInterface[]
   */
  protected $segments = [];

  /**
   * @var string
   */
  protected $state;

  public static function split($path) {
    return preg_split('|[\\\/]+|', $path, -1, PREG_SPLIT_NO_EMPTY);
  }

  public function __construct($path) {
    if (false !== strpos($path, '@')) {
      list($path, $this->state) = explode('@', $path, 2);
    }
    $this->makeSegments($path);
  }

  public function __toString() {
    return implode(self::DELIMITER, $this->segments);
  }

  public function count() {
    return count($this->segments);
  }

  /**
   * @return string
   */
  public function getPartial() {
    return $this->hasType() ? implode('-', [$this->getType(), $this->getName()]) : $this->getName();
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
    return implode('--', array_slice($this->segments, $this->getNameSegmentIndex()));
  }

  /**
   * @return string|null
   */
  public function getState() {
    return $this->state;
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