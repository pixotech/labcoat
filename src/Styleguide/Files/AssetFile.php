<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Assets\AssetInterface;
use Labcoat\Styleguide\StyleguideInterface;

class AssetFile extends File implements AssetFileInterface {

  protected $asset;

  public function __construct(AssetInterface $asset) {
    $this->asset = $asset;
  }

  public function getAsset() {
    return $this->asset;
  }

  public function getPath() {
    return $this->asset->getPath();
  }

  public function getTime() {
    return filemtime($this->asset->getFile());
  }

  public function put(StyleguideInterface $styleguide, $path) {
    copy($this->asset->getFile(), $path);
  }
}