<?php

namespace Labcoat\Styleguide\Files;

class AnnotationsFile extends File implements AnnotationsFileInterface {

  public function getContents() {
    // TODO: Implement getContents() method.
  }

  public function getPath() {
    return $this->makePath(['annotations', 'annotations.js']);
  }

  public function getTime() {
    // TODO: Implement getTime() method.
  }
}