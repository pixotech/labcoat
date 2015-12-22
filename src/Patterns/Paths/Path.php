<?php

namespace Labcoat\Patterns\Paths;

class Path implements \Countable, PathInterface {

  const DELIMITER = '/';

  /**
   * @var array
   */
  protected $segments = [];

  public static function split($path) {
    return preg_split('|[\\\/]+|', $path, -1, PREG_SPLIT_NO_EMPTY);
  }

  public function __construct($path) {
    $this->segments = static::split($path);
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
  public function getPath() {
    return $this->__toString();
  }

  /**
   * @return Name
   */
  public function getName() {
    return new Name(implode('-', $this->getNameSegments()));
  }

  /**
   * @return Segment
   */
  public function getSubtype() {
    if (!$this->hasSubtype()) throw new \BadMethodCallException("Path does not have subtype");
    return $this->segments[1];
  }

  /**
   * @return Segment
   */
  public function getType() {
    if (!$this->hasType()) throw new \BadMethodCallException("Path does not have type");
    return $this->segments[0];
  }

  /**
   * @return bool
   */
  public function hasSubtype() {
    return $this->count() > 2;
  }

  /**
   * @return bool
   */
  public function hasType() {
    return $this->count() > 1;
  }

  /**
   * @param string $delimiter
   * @return string
   */
  public function join($delimiter) {
    return implode($delimiter, $this->segments);
  }

  protected function getNameSegmentIndex() {
    if ($this->hasSubtype()) return 2;
    elseif ($this->hasType()) return 1;
    return 0;
  }

  protected function getNameSegments() {
    return array_slice($this->segments, $this->getNameSegmentIndex());
  }

  protected function makeSegments($path) {
    foreach (self::split($path) as $segment) {
      $this->segments[] = new Segment($segment);
    }
  }
}