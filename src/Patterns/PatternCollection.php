<?php

namespace Labcoat\Patterns;

use Labcoat\PatternLab;
use Labcoat\PatternLabInterface;

class PatternCollection extends PatternSection implements PatternCollectionInterface {

  public function __construct(PatternLabInterface $patternlab) {
    $this->findPatterns($patternlab);
    #$this->findData($patternlab);
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
    $n = PatternLab::stripDigits($name);
    foreach ($this->getTypes() as $typeName => $type) {
      if (PatternLab::stripDigits($typeName) == $n) return $type;
    }
    throw new \OutOfBoundsException("Unknown type: $name");
  }

  public function getAllPatterns() {
    return $this->getPatterns();
  }

  public function getPattern($name) {
    return PatternLab::isPartialName($name) ? $this->getPatternByPartial($name) : $this->getPatternByPath($name);
  }

  public function getPatterns() {
    return iterator_to_array($this->getPatternsIterator(), false);
  }

  public function getPatternsIterator() {
    return new \RecursiveIteratorIterator($this);
  }

  public function getPatternByPartial($name) {
    list($type, $name) = PatternLab::splitPartial($name);
    return $this->findType($type)->findAnyPattern($name);
  }

  public function getPatternByPath($path) {
    list($type, $subtype, $name) = PatternLab::splitPath($path);
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

  protected function findData(PatternLabInterface $patternlab) {
    $dir = $patternlab->getPatternsDirectory();
    $flags = \FilesystemIterator::CURRENT_AS_PATHNAME | \FilesystemIterator::SKIP_DOTS;
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, $flags));
    $matches = new \RegexIterator($files, '|\.json$|', \RegexIterator::MATCH);
    foreach ($matches as $match) {
      $path = substr($match, strlen($dir) + 1, -5);
      list ($path, $pseudoPattern) = array_pad(explode('~', $path, 2), 2, null);
      if ($pattern = $this->getPatternByPath($path)) {
        if ($pseudoPattern) $pattern->addPseudoPattern($pseudoPattern, $match);
        else $pattern->setDataFile($match);
      }
    }
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