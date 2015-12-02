<?php

namespace Labcoat\Styleguide\Navigation;

abstract class TypeItem extends Item implements TypeItemInterface {

  public function getPath() {
    return implode('/', [$this->getName(), 'index.html']);
  }

  public function getPartial() {
    return implode('-', ['viewall', $this->getType(), $this->getSubtype()]);
  }

  public function jsonSerialize() {
    return [
      "patternPath" => $this->getPath(),
      "patternName" => $this->getName(),
      "patternType" => $this->getType(),
      "patternSubtype" => $this->getSubtype(),
      "patternPartial" => $this->getPartial(),
    ];
  }
}