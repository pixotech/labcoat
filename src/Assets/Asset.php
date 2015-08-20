<?php

namespace Labcoat\Assets;

class Asset implements AssetInterface {

  protected $file;
  protected $path;

  public function __construct($path, \SplFileInfo $file) {
    $this->path = $path;
    $this->file = $file;
  }

  /**
   * @return \SplFileInfo
   */
  public function getFile() {
    return $this->file;
  }

  public function getPath() {
    return $this->path;
  }
}