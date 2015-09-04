<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\SubtypeInterface;
use Labcoat\Patterns\TypeInterface;

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

  public function addSubtype(SubtypeInterface $subtype) {
    $this->types[$subtype->getType()->getName()]->addSubtype(new Subtype($subtype));
  }

  public function addType(TypeInterface $type) {
    $this->types[$type->getName()] = new Type($type);
  }
}