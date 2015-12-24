<?php

namespace Labcoat\Styleguide;

use Labcoat\PatternLabInterface;
use Labcoat\PatternLab\Styleguide\Styleguide as PatternLabStyleguide;

class Styleguide implements StyleguideInterface {

  protected $styleguide;

  public function __construct(PatternLabInterface $labcoat) {
    $this->styleguide = new PatternLabStyleguide($labcoat);
  }

  public function generate($directory) {
    return $this->styleguide->generate($directory);
  }
}