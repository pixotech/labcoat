<?php

namespace Labcoat\PatternLab\Styleguide\Files\Text;

use Labcoat\Generator\Files\File;
use Labcoat\Generator\Paths\Path;
use Labcoat\PatternLab\Styleguide\Files\Text\LatestChangeFileInterface;

class LatestChangeFile extends File implements LatestChangeFileInterface {

  protected $time;

  public function __construct($time) {
    $this->time = $time;
  }

  public function getPath() {
    return new Path('latest-change.txt');
  }

  public function getTime() {
    return $this->time;
  }

  public function put($path) {
    file_put_contents($path, $this->time);
  }
}