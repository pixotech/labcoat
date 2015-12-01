<?php

namespace Labcoat\Structure;

use Labcoat\PatternLab;
use Labcoat\Filters\PatternFilterIterator;
use Labcoat\Filters\SubtypeFilterIterator;
use Labcoat\Paths\Path;
use Labcoat\Patterns\PatternInterface;

class Type extends Folder implements TypeInterface {

  public function findAnyPattern($name) {
    return $this->getAllPatterns()[Path::stripDigits($name)];
  }

  /**
   * @param $name
   * @return SubtypeInterface
   * @throws \OutOfBoundsException
   */
  public function findPattern($name) {
    return $this->getPatterns()[Path::stripDigits($name)];
  }

  /**
   * @param $name
   * @return SubtypeInterface
   * @throws \OutOfBoundsException
   */
  public function findSubType($name) {
    return $this->getSubTypes()[Path::stripDigits($name)];
  }

  /**
   * @param $name
   * @return SubtypeInterface
   */
  public function getSubtype($name) {
    return $this->items[$name];
  }

  /**
   * @return SubtypeInterface[]
   */
  public function getSubTypes() {
    return iterator_to_array($this->getSubTypesIterator());
  }

  public function hasSubtypes() {
    return count($this->getSubTypes()) > 0;
  }

  protected function getAllPatternsIterator() {
    $iterator = new \RecursiveIteratorIterator($this, \RecursiveIteratorIterator::SELF_FIRST);
    return new PatternFilterIterator($iterator, false);
  }

  protected function getPatternsIterator() {
    return new PatternFilterIterator($this);
  }

  /**
   * @param $path
   * @return SubtypeInterface
   */
  protected function getOrCreateSubtype($path) {
    list(, $key) = explode('/', PatternLab::normalizePath($path));
    if (!isset($this->items[$key])) $this->items[$key] = new Subtype($path);
    return $this->items[$key];
  }

  protected function getSubTypesIterator() {
    return new SubtypeFilterIterator($this);
  }
}