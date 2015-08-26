<?php

namespace Labcoat\Patterns;

class PatternSubType extends PatternGroup {

  protected $name;
  protected $type;

  public function __construct(PatternType $type, $name) {
    $this->type = $type;
    $this->name = $name;
  }

  public function add(PatternInterface $pattern) {
    $this->addPattern($pattern);
  }

  /**
   * @param $name
   * @return PatternSubType
   * @throws \OutOfBoundsException
   */
  public function findPattern($name) {
    return $this->getPatterns()[Pattern::stripOrdering($name)];
  }

  public function getAllPatterns() {
    return $this->getPatterns();
  }

  public function getName() {
    return $this->name;
  }

  public function getPath() {
    return $this->getType()->getPath() . '-' . $this->name;
  }

  /**
   * @return Pattern[]
   */
  public function getPatterns() {
    return $this->items;
  }

  public function getStyleguidePathName() {
    return $this->type->getName() . '-' . $this->getName();
  }

  /**
   * @return PatternType
   */
  public function getType() {
    return $this->type;
  }
}