<?php

namespace Labcoat\Generator\Files;

use Labcoat\Generator\Paths\Path;

class AssetFile extends File implements AssetFileInterface {

  protected $file;
  protected $path;

  public function __construct($path, $file) {
    $this->path = $path;
    $this->file = $file;
  }

  public function getPath() {
    return new Path($this->path);
  }

  public function getTime() {
    return filemtime($this->file);
  }

  public function put($path) {
    copy($this->file, $path);
  }
}