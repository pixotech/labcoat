<?php

namespace Labcoat\Assets;

use Labcoat\PatternLabInterface;

class Copier implements CopierInterface {

  /**
   * @var PatternLabInterface
   */
  protected $patternlab;

  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
  }

  public function copyTo($destination) {
    if (!is_dir($destination)) throw new \InvalidArgumentException("Not a directory: $destination");
    foreach ($this->getAssets() as $asset) {
      $destinationPath = $destination . DIRECTORY_SEPARATOR . $asset->getPath();
      $this->ensureDirectory(dirname($destinationPath));
      copy($asset->getFile(), $destinationPath);
    }
  }

  protected function ensureDirectory($path) {
    if (!is_dir($path)) {
      if ($dir = dirname($path)) $this->ensureDirectory($dir);
      mkdir($path);
    }
  }

  protected function getAssets() {
    return $this->patternlab->getAssets();
  }
}