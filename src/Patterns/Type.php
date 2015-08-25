<?php

namespace Labcoat\Patterns;

use Labcoat\Patterns\Filters\PatternFilterIterator;
use Labcoat\Patterns\Filters\SubTypeFilterIterator;
use RecursiveIterator;

class Type extends Group implements \RecursiveIterator {

  protected $name;

  /**
   * @var Pattern[]
   */
  protected $patterns;

  public function __construct($name) {
    $this->name = $name;
  }

  public function add(PatternInterface $pattern) {
    if ($pattern->hasSubType()) $this->getSubType($pattern->getSubType())->add($pattern);
    else $this->addPattern($pattern);
    $this->patterns[$pattern->getName()] = $pattern;
    ksort($this->patterns, SORT_NATURAL);
  }

  public function findAnyPattern($name) {
    return $this->getAllPatterns()[Pattern::stripOrdering($name)];
  }

  /**
   * @param $name
   * @return SubType
   * @throws \OutOfBoundsException
   */
  public function findPattern($name) {
    return $this->getPatterns()[Pattern::stripOrdering($name)];
  }

  /**
   * @param $name
   * @return SubType
   * @throws \OutOfBoundsException
   */
  public function findSubType($name) {
    return $this->getSubTypes()[Pattern::stripOrdering($name)];
  }

  public function getAllPatterns() {
    return iterator_to_array($this->getAllPatternsIterator());
  }

  public function getName() {
    return $this->name;
  }

  /**
   * @return Pattern[]
   */
  public function getPatterns() {
    return iterator_to_array($this->getPatternsIterator());
  }

  /**
   * @param $name
   * @return SubType
   */
  public function getSubType($name) {
    if (!isset($this->items[$name])) $this->addItem($name, new SubType($name));
    return $this->items[$name];
  }

  /**
   * @return SubType[]
   */
  public function getSubTypes() {
    return iterator_to_array($this->getSubTypesIterator());
  }

  protected function getAllPatternsIterator() {
    return new \RecursiveIteratorIterator($this, \RecursiveIteratorIterator::LEAVES_ONLY);
  }

  protected function getPatternsIterator() {
    return new PatternFilterIterator($this);
  }

  protected function getSubTypesIterator() {
    return new SubTypeFilterIterator($this);
  }
}