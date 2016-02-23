<?php

namespace Labcoat\Twig;

use Labcoat\PatternLab;
use Labcoat\PatternLab\PatternInterface;
use Labcoat\PatternLabInterface;

class Loader implements \Twig_LoaderInterface {

  protected $extension = 'twig';
  protected $index;

  public static function isPath($selector) {
    return strpbrk($selector, DIRECTORY_SEPARATOR . '/') !== false;
  }

  public function __construct(PatternLabInterface $patternlab) {
    $this->makeIndex($patternlab);
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
    $key = $this->isPath($name) ? PatternLab::normalizePath($this->stripExtension($name)) : $name;
    if (isset($this->index[$key])) return $this->index[$key];
    throw new \Twig_Error_Loader("Unknown pattern: $name");
  }

  protected function makeIndex(PatternLabInterface $patternlab) {
    $this->index = [];
    foreach ($patternlab->getPatterns() as $pattern) {
      $file = $pattern->getFile();
      $partial = $this->makePartial($pattern);
      $path = PatternLab::normalizePath($pattern->getPath());
      $this->index[$partial] = $file;
      $this->index[$path] = $file;
    }
  }

  protected function makePartial(PatternInterface $pattern) {
    return $pattern->hasType() ? "{$pattern->getType()}-{$pattern->getName()}" : $pattern->getName();
  }

  protected function stripExtension($path) {
    $ext = '.' . $this->extension;
    if (substr($path, 0 - strlen($ext)) == $ext) $path = substr($path, 0, 0 - strlen($ext));
    return $path;
  }
}