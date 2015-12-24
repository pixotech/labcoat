<?php

namespace Labcoat\PatternLab\Styleguide\Files\Assets;

use Labcoat\Generator\Files\File;
use Labcoat\Generator\Paths\Path;

class AssetFile extends File implements AssetFileInterface {

  protected $file;
  protected $path;

  public function __construct($path, $file) {
    $this->path = $path;
    $this->file = $file;
  }

  public function getPath() {
    $path = $this->path;
    switch (dirname($path)) {
      case 'html':
        return new Path(basename($path));
      case 'css/custom':
      case 'css/patternlab':
        $path = 'css/' . basename($path);
      default:
        return new Path('styleguide/' . $path);
    }
  }

  public function getTime() {
    return filemtime($this->file);
  }

  public function put($path) {
    copy($this->file, $path);
  }
}