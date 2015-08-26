<?php

namespace Labcoat\Styleguide\Files;

abstract class File implements FileInterface {

  protected function makePath(array $segments) {
    return implode(DIRECTORY_SEPARATOR, $segments);
  }
}