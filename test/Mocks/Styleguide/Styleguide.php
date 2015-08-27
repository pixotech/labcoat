<?php

namespace Labcoat\Mocks\Styleguide;

use Labcoat\Styleguide\StyleguideInterface;

class Styleguide implements StyleguideInterface {

  public $patternlab;

  public function getGlobalData() {
    // TODO: Implement getGlobalData() method.
  }

  public function getPatternLab() {
    return $this->patternlab;
  }
}