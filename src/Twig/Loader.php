<?php

namespace Labcoat\Twig;

use Labcoat\PatternLabInterface;

class Loader implements \Twig_LoaderInterface {

  protected $patternlab;

  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
  }

  public function getSource($name) {
    return file_get_contents($this->getTemplateFile($name)->getFile()->getPathname());
  }

  public function getCacheKey($name) {
    return md5($this->getTemplateFile($name)->getTemplate());
  }

  public function isFresh($name, $time) {
    return $this->getTemplateFile($name)->getFile()->getMTime() > $time;
  }

  /**
   * @param $name
   * @return \Labcoat\Patterns\PatternInterface
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

  protected function getTemplateFile($name) {
    if ($this->patternlab->hasLayout($name)) return $this->patternlab->getLayoutFile($name);
    return $this->getPattern($name);
  }
}