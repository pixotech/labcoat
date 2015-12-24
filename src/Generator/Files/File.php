<?php

namespace Labcoat\Generator\Files;

abstract class File implements FileInterface {

  protected function makePath(array $segments) {
    return implode(DIRECTORY_SEPARATOR, $segments);
  }
}