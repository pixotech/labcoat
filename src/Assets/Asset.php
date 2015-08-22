<?php

namespace Labcoat\Assets;

use Labcoat\Filesystem\File;

class Asset implements AssetInterface {

  protected $file;
  protected $path;

  public function __construct(File $file) {
    $this->path = $file->getPath();
    $this->file = $file->getFullPath();
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