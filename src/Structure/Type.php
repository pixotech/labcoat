<?php

namespace Labcoat\Structure;

use Labcoat\ItemInterface;
use Labcoat\PatternLab;
use Labcoat\Filters\PatternFilterIterator;
use Labcoat\Filters\SubtypeFilterIterator;
use Labcoat\Patterns\Path;
use Labcoat\Patterns\PatternInterface;

class Type extends Folder implements ItemInterface, TypeInterface {

  public function __construct($path) {
    $this->id = $path;
    $this->path = $path;
  }

  public function addPattern(PatternInterface $pattern) {
    $keys = explode('/', $pattern->getNormalizedPath());
    switch (count($keys)) {
      case 3:
        $subtype = dirname($pattern->getPath());
        $this->getOrCreateSubtype($subtype)->addPattern($pattern);
        break;
      case 2:
        $this->items[$keys[1]] = $pattern;
        break;
      default:
        throw new \InvalidArgumentException("Invalid path");
    }
  }

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

  public function getAllPatterns() {
    return iterator_to_array($this->getAllPatternsIterator());
  }

  /**
   * @return PatternInterface[]
   */
  public function getPatterns() {
    return iterator_to_array($this->getPatternsIterator());
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