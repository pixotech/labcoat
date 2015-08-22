<?php

namespace Labcoat\Patterns;

use Labcoat\Data\Data;
use Labcoat\Filesystem\FileInterface;
use Labcoat\PatternLab;

class Pattern implements PatternInterface {

  protected $data;
  protected $file;
  protected $name;
  protected $path;
  protected $subType;
  protected $type;

  public function __construct(FileInterface $file) {
    $this->file = $file->getFullPath();
    $this->path = PatternLab::normalizePath($file->getPathWithoutExtension());
    $parts = explode('/', $this->path);
    $this->name = array_pop($parts);
    $this->type = array_shift($parts);
    if (!empty($parts)) $this->subType = array_shift($parts);
    $this->findData($file);
  }

  public function getData() {
    return new Data(file_get_contents($this->data));
  }

  public function getFile() {
    return $this->file;
  }

  public function getPath() {
    return $this->path;
  }

  public function getShorthand() {
    return $this->type . '-' . $this->name;
  }

  public function hasData() {
    return !empty($this->data);
  }

  protected function findData(FileInterface $file) {
    $path = $this->getDataFilePath($file);
    if (is_file($path)) $this->data = $path;
  }

  protected function getDataFilePath(FileInterface $file) {
    $dir = dirname($file->getFullPath());
    $basename = basename($file->getPathWithoutExtension());
    return $dir . DIRECTORY_SEPARATOR . $basename . '.json';
  }
}