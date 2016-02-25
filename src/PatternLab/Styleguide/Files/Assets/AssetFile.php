<?php

namespace Labcoat\PatternLab\Styleguide\Files\Assets;

use Labcoat\Generator\Paths\Path;

class AssetFile extends \Labcoat\Generator\Files\AssetFile implements AssetFileInterface {

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
}