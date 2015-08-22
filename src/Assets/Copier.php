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

  public function copyTo($path) {
    if (!is_dir($path)) throw new \InvalidArgumentException("Not a directory: $path");
    foreach ($this->patternlab->getAssets() as $asset) {
      $this->ensureSubdirectory($path, dirname($asset->getPath()));
      copy($asset->getFile(), $this->makeSubdirectoryPath($path, $asset->getPath()));
    }
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