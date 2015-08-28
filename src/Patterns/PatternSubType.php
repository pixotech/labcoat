<?php

namespace Labcoat\Patterns;

use Labcoat\PatternLab;

class PatternSubType extends PatternSection implements PatternSubTypeInterface {

  protected $name;
  protected $type;

  public function __construct(PatternTypeInterface $type, $name) {
    $this->type = $type;
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

  public function getLowercaseName() {
    return str_replace('-', ' ', $this->getNameWithoutDigits());
  }

  public function getName() {
    return $this->name;
  }

  public function getNameWithoutDigits() {
    return PatternLab::stripDigits($this->getName());
  }

  public function getPath() {
    return $this->getType()->getPath() . '-' . $this->getName();
  }

  /**
   * @return PatternInterface[]
   */
  public function getPatterns() {
    return $this->items;
  }

  public function getStyleguidePathName() {
    return $this->type->getName() . '-' . $this->getName();
  }

  /**
   * @return PatternTypeInterface
   */
  public function getType() {
    return $this->type;
  }

  public function getUppercaseName() {
    return ucwords($this->getLowercaseName());
  }
}