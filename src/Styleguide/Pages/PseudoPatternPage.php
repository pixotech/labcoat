<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

class PseudoPatternPage extends PatternPage {

  protected $name;

  public function __construct(StyleguideInterface $styleguide, PatternInterface $pattern, $name) {
    parent::__construct($styleguide, $pattern);
    $this->name = $name;
  }

  public function getPath() {
    return parent::getPath() . '-' . $this->name;
  }
}