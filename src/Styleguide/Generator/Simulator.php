<?php

namespace Labcoat\Styleguide\Generator;

use Labcoat\Styleguide\StyleguideInterface;

class Simulator implements GeneratorInterface {

  protected $path;
  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide, $path) {
    $this->styleguide = $styleguide;
    $this->path = $path;
  }
}