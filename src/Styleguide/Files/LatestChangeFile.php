<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Generator\Files\File;
use Labcoat\Styleguide\StyleguideInterface;

class LatestChangeFile extends File implements LatestChangeFileInterface {

  protected $time;

  public function __construct($time) {
    $this->time = $time;
  }

  public function getPath() {
    return 'latest-change.txt';
  }

  public function getTime() {
    return $this->time;
  }

  public function put(StyleguideInterface $styleguide, $path) {
    file_put_contents($path, $this->time);
  }
}