<?php

namespace Pixo\PatternLab\Twig;

use Pixo\PatternLab\PatternLabInterface;

class Loader implements \Twig_LoaderInterface {

  protected $patternlab;

  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
  }

  public function getSource($name) {
    return file_get_contents($this->getPattern($name)->getFile()->getPathname());
  }

  public function getCacheKey($name) {
    return md5($this->getPattern($name)->getTemplate());
  }

  public function isFresh($name, $time) {
    return $this->getPattern($name)->getFile()->getMTime() > $time;
  }

  /**
   * @param $name
   * @return \Pixo\PatternLab\Patterns\PatternInterface
   * @throws \Twig_Error_Loader
   */
  protected function getPattern($name) {
    try {
      return $this->patternlab->getPatterns()->get($name);
    }
    catch (\OutOfBoundsException $e) {
      throw new \Twig_Error_Loader($e->getMessage());
    }
  }
}