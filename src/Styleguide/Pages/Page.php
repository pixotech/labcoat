<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\StyleguideInterface;

abstract class Page implements PageInterface {

  public function getFooterVariables(StyleguideInterface $styleguide) {
    return [];
  }

  public function getHeaderVariables(StyleguideInterface $styleguide) {
    return [];
  }
}