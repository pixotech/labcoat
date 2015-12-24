<?php

namespace Labcoat\Styleguide\Files\Javascript;

use Labcoat\Generator\Files\File;
use Labcoat\Styleguide\StyleguideInterface;

class AnnotationsFile extends File implements AnnotationsFileInterface {

  protected $path;

  public function __construct($path) {
    $this->path = $path;
  }

  public function getPath() {
    return $this->makePath(['annotations', 'annotations.js']);
  }

  public function getTime() {
    return filemtime($this->path);
  }

  public function put(StyleguideInterface $styleguide, $path) {
    copy($this->path, $path);
  }
}