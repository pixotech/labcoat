<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\StyleguideInterface;

interface PageInterface {
  public function getPath();
  public function render(StyleguideInterface $styleguide);
}