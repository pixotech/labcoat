<?php

namespace Labcoat\Styleguide\Navigation;

abstract class Item implements ItemInterface {

  public function jsonSerialize() {
    return [
      'patternPath' => $this->getPath(),
      'patternName' => $this->getName(),
      'patternPartial' => $this->getPartial(),
    ];
  }
}