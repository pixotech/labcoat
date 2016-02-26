<?php

namespace Labcoat\Styleguide;

use Labcoat\PatternLabInterface;

/**
 * @deprecated 1.1.0 PatternLab classes moved to \Labcoat\PatternLab
 */
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