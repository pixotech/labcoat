<?php

namespace Labcoat\Styleguide\Files;

class StyleguideAssetFile extends AssetFile implements AssetFileInterface {

  public function getPath() {
    return $this->makePath(['styleguide', parent::getPath()]);
  }
}