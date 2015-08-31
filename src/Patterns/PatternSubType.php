<?php

namespace Labcoat\Patterns;

use Labcoat\PatternLab;

class PatternSubType extends PatternSection implements PatternSubTypeInterface {

  protected $name;

  public function __construct($name) {
    $this->name = $name;
  }

  public function add(PatternInterface $pattern) {
    $this->addPattern($pattern);
  }

  /**
   * @param $name
   * @return PatternInterface
   * @throws \OutOfBoundsException
   */
  public function findPattern($name) {
    return $this->getPatterns()[PatternLab::stripDigits($name)];
  }

  public function getAllPatterns() {
    return $this->getPatterns();
  }

  public function getName() {
    return $this->name;
  }

  /**
   * @return PatternInterface[]
   */
  public function getPatterns() {
    return $this->items;
  }
}