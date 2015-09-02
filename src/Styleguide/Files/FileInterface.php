<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Styleguide\StyleguideInterface;

interface FileInterface {
  public function getPath();
  public function getTime();
  public function put(StyleguideInterface $styleguide, $path);
}