<?php

namespace Pixo\PatternLab\Assets;

class AssetCollection implements AssetCollectionInterface, \Countable, \IteratorAggregate {

  /**
   * @var Asset[]
   */
  protected $assets;

  public function add(AssetInterface $asset) {
    $this->assets[$asset->getPath()] = $asset;
  }

  public function copyTo($directory) {
    if (!is_dir($directory)) throw new \InvalidArgumentException("Not a directory: $directory");
    foreach ($this->assets as $asset) {
      $this->ensureSubdirectory($directory, dirname($asset->getPath()));
      copy($asset->getFile()->getPathname(), $this->makeSubdirectoryPath($directory, $asset->getPath()));
    }
  }

  public function count() {
    return count($this->assets);
  }

  public function getIterator() {
    return new \ArrayIterator($this->assets);
  }

  protected function ensureSubdirectory($directory, $path) {
    if ($path && !is_dir($this->makeSubdirectoryPath($directory, $path))) {
      $this->ensureSubdirectory($directory, dirname($path));
      mkdir($this->makeSubdirectoryPath($directory, $path));
    }
  }

  protected function makeSubdirectoryPath($directory, $path) {
    return $directory . DIRECTORY_SEPARATOR . $path;
  }
}