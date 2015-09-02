<?php

namespace Labcoat\Assets;

use Labcoat\PatternLabInterface;

class AssetDirectory implements AssetDirectoryInterface {

  protected $assets = [];
  protected $path;

  public function __construct(PatternLabInterface $patternlab, $path) {
    $this->path = $path;
    $this->findAssets($patternlab);
  }

  public function getAssets() {
    return $this->assets;
  }

  protected function findAssets(PatternLabInterface $patternlab) {
    $dir = new \RecursiveDirectoryIterator($this->path, \FilesystemIterator::CURRENT_AS_PATHNAME | \FilesystemIterator::SKIP_DOTS);
    $files = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($files as $path) {
      $relativePath = substr($path, strlen($this->path) + 1);
      if (!$patternlab->isHiddenFile($relativePath) && !$patternlab->isIgnoredFile($relativePath)) {
        $this->assets[$relativePath] = $path;
      }
    }
  }
}