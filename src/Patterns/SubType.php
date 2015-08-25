<?php

namespace Labcoat\Patterns;

class SubType extends Group {

  protected $name;

  public function __construct($name) {
    $this->name = $name;
  }

  public function add(PatternInterface $pattern) {
    $this->addPattern($pattern);
  }

  /**
   * @param $name
   * @return SubType
   * @throws \OutOfBoundsException
   */
  public function findPattern($name) {
    return $this->getPatterns()[Pattern::stripOrdering($name)];
  }

  public function getName() {
    return $this->name;
  }

  /**
   * @return Pattern[]
   */
  public function getPatterns() {
    return $this->items;
  }
}