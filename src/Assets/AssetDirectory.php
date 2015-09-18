<?php

namespace Labcoat\Assets;

use Labcoat\PatternLabInterface;

class AssetDirectory implements \Countable, \IteratorAggregate, AssetDirectoryInterface {

  protected $assets = [];
  protected $path;

  public function __construct(PatternLabInterface $patternlab, $path) {
    $this->path = $path;
    $this->findAssets($patternlab);
  }

  public function count() {
    return count($this->assets);
  }

  public function getAssets() {
    return $this->assets;
  }

  public function getIterator() {
    return new \ArrayIterator($this->assets);
  }

  protected function findAssets(PatternLabInterface $patternlab) {
    $dir = new \RecursiveDirectoryIterator($this->path, \FilesystemIterator::SKIP_DOTS);
    $files = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($files as $file => $obj) {
      $path = substr($file, strlen($this->path) + 1);
      if (!$patternlab->isHiddenFile($path) && !$patternlab->isIgnoredFile($path)) {
        $this->assets[$path] = new Asset($path, $file);
      }
    }
  }
}