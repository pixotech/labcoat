<?php

namespace Labcoat\Twig;

use Labcoat\PatternLabInterface;

class Loader implements \Twig_LoaderInterface {

  protected $patternlab;

  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
  }

  public function getSource($name) {
    return file_get_contents($this->getFile($name));
  }

  public function getCacheKey($name) {
    return md5($this->getFile($name));
  }

  public function isFresh($name, $time) {
    return filemtime($this->getFile($name)) > $time;
  }

  /**
   * @param $name
   * @return string
   * @throws \Twig_Error_Loader
   */
  protected function getFile($name) {
    try {
      return $this->patternlab->getPattern($name)->getFile();
    }
    catch (\OutOfBoundsException $e) {
      throw new \Twig_Error_Loader($e->getMessage());
    }
  }
}