<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\StyleguideInterface;

abstract class Page implements PageInterface {

  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide) {
    $this->styleguide = $styleguide;
  }
}