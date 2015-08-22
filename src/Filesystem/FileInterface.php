<?php

namespace Labcoat\Filesystem;

interface FileInterface {
  public function getExtension();
  public function getFullPath();
  public function getPath();
  public function getPathWithoutExtension();
  public function isHidden();
}