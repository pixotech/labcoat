<?php

namespace Labcoat\Styleguide\Navigation\Items;

abstract class Item implements ItemInterface {

  public function jsonSerialize() {
    return [
      'patternPath' => $this->getPath(),
      'patternName' => $this->getName(),
      'patternPartial' => $this->getPartial(),
    ];
  }
}