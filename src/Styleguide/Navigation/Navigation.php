<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PatternSubTypeInterface;
use Labcoat\Patterns\PatternTypeInterface;

class Navigation implements \JsonSerializable {

  /**
   * @var Type[]
   */
  protected $types = [];

  public function jsonSerialize() {
    return [
      'patternTypes' => array_values($this->types),
    ];
  }

  public function addPattern(PatternInterface $pattern) {
    $type = $pattern->getType();
    $this->types[$type]->addPattern($pattern);
  }

  public function addSubtype(PatternSubTypeInterface $subtype) {
    $this->types[$subtype->getType()->getName()]->addSubtype(new Subtype($subtype));
  }

  public function addType(PatternTypeInterface $type) {
    $this->types[$type->getName()] = new Type($type);
  }
}