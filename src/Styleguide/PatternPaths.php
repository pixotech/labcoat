<?php

namespace Labcoat\Styleguide;

class PatternPaths implements \JsonSerializable {


  public function jsonSerialize() {
    return [
      'patternPaths' => $this->getPaths(),
    ];
  }
}