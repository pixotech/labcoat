<?php

namespace Labcoat\Patterns;

use Labcoat\PatternLabInterface;

class PatternCollection extends Group implements PatternCollectionInterface {

  public function __construct(PatternLabInterface $patternlab) {
    $this->findPatterns($patternlab);
  }

  public function add(PatternInterface $pattern) {
    $this->ensureType($pattern->getType());
    $this->getType($pattern->getType())->add($pattern);
  }

  /**
   * @param $name
   * @return Type
   * @throws \OutOfBoundsException
   */
  public function findType($name) {
    $n = Pattern::stripOrdering($name);
    foreach ($this->getTypes() as $typeName => $type) {
      if (Pattern::stripOrdering($typeName) == $n) return $type;
    }
    throw new \OutOfBoundsException("Unknown type: $name");
  }

  public function getPattern($name) {
    return Pattern::isPartialName($name) ? $this->getPatternByPartial($name) : $this->getPatternByPath($name);
  }

  public function getPatternsIterator() {
    return new \RecursiveIteratorIterator($this);
  }

  public function getPatternByPartial($name) {
    list($type, $name) = Pattern::splitPartial($name);
    return $this->findType($type)->findAnyPattern($name);
  }

  public function getPatternByPath($path) {
    list($type, $subtype, $name) = Pattern::splitPath($path);
    $type = $this->findType($type);
    return $subtype ? $type->findSubType($subtype)->findPattern($name) : $type->findPattern($name);
  }

  /**
   * @param $name
   * @return Type
   */
  public function getType($name) {
    return $this->items[$name];
  }

  public function getTypes() {
    return $this->items;
  }

  public function hasType($name) {
    return array_key_exists($name, $this->items);
  }

  protected function findPatterns(PatternLabInterface $patternlab) {
    $dir = $patternlab->getPatternsDirectory();
    $ext = $patternlab->getPatternExtension();
    $flags = \FilesystemIterator::CURRENT_AS_PATHNAME | \FilesystemIterator::SKIP_DOTS;
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, $flags));
    $pattern = '|\.' . preg_quote($ext) . '$|';
    $matches = new \RegexIterator($files, $pattern, \RegexIterator::MATCH);
    foreach ($matches as $match) {
      $path = substr($match, strlen($dir) + 1, -1 - strlen($ext));
      $this->add(new Pattern($path, $match));
    }
  }

  /**
   * @param $name
   * @return Type
   */
  protected function addType($name) {
    $this->addItem($name, new Type($name));
  }

  protected function ensureType($name) {
    if (!$this->hasType($name)) $this->addType($name);
  }
}