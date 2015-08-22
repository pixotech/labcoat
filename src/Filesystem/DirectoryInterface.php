<?php

namespace Labcoat\Filesystem;

interface DirectoryInterface extends FileInterface {
  public function getDirectory($path);
  public function getFile($path);
  public function getFilesWithExtension($extension);
}