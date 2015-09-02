<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Styleguide\StyleguideInterface;

class AnnotationsFile extends File implements AnnotationsFileInterface {

  public function getPath() {
    return $this->makePath(['annotations', 'annotations.js']);
  }

  public function getTime() {
    // TODO: Implement getTime() method.
  }

  public function put(StyleguideInterface $styleguide, $path) {
    file_put_contents($path, '');
  }
}