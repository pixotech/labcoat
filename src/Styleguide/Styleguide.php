<?php

namespace Labcoat\Styleguide;

use Labcoat\PatternLabInterface;

class Styleguide implements StyleguideInterface {

  protected $styleguide;

  public function __construct(PatternLabInterface $labcoat) {
    $this->styleguide = $labcoat->getStyleguide();
  }

  public function __toString() {
    return (string)$this->styleguide;
  }

  public function generate($directory) {
    return $this->styleguide->generate($directory);
  }
}