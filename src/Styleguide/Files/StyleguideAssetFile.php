<?php

namespace Labcoat\Styleguide\Files;

class StyleguideAssetFile extends AssetFile implements AssetFileInterface {

  public function getPath() {
    $path = parent::getPath();
    switch (dirname($path)) {
      case 'html':
        return basename($path);
      case 'css/custom':
      case 'css/patternlab':
        $path = $this->makePath(['css', basename($path)]);
      default:
        return $this->makePath(['styleguide', $path]);
    }
  }
}