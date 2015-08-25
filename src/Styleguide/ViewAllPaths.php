<?php

namespace Labcoat\Styleguide;

class ViewAllPaths implements \JsonSerializable {


  public function jsonSerialize() {
    return [
      'viewAllPaths' => $this->getPaths(),
    ];
  }
}