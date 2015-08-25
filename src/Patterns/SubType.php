<?php

namespace Labcoat\Patterns;

class SubType extends Group {

  protected $name;
  protected $type;

  public function __construct(Type $type, $name) {
    $this->type = $type;
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

  public function getPath() {
    return $this->getType()->getPath() . '-' . $this->name;
  }

  /**
   * @return Pattern[]
   */
  public function getPatterns() {
    return $this->items;
  }

  /**
   * @return Type
   */
  public function getType() {
    return $this->type;
  }
}