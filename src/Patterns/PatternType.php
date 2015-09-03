<?php

namespace Labcoat\Patterns;

use Labcoat\PatternLab;
use Labcoat\Patterns\Filters\PatternFilterIterator;
use Labcoat\Patterns\Filters\SubTypeFilterIterator;
use RecursiveIterator;

class PatternType extends PatternSection implements \RecursiveIterator, PatternTypeInterface {

  protected $name;

  /**
   * @var Pattern[]
   */
  protected $patterns;

  public function __construct($name) {
    $this->name = $name;
  }

  public function add(PatternInterface $pattern) {
    if ($pattern->hasSubType()) {
      $this->ensureSubType($pattern->getSubType());
      $this->getSubType($pattern->getSubType())->add($pattern);
    }
    else {
      $this->addPattern($pattern);
    }
    $this->patterns[$pattern->getName()] = $pattern;
    ksort($this->patterns, SORT_NATURAL);
  }

  public function findAnyPattern($name) {
    return $this->getAllPatterns()[PatternLab::stripDigits($name)];
  }

  /**
   * @param $name
   * @return PatternSubTypeInterface
   * @throws \OutOfBoundsException
   */
  public function findPattern($name) {
    return $this->getPatterns()[PatternLab::stripDigits($name)];
  }

  /**
   * @param $name
   * @return PatternSubTypeInterface
   * @throws \OutOfBoundsException
   */
  public function findSubType($name) {
    return $this->getSubTypes()[PatternLab::stripDigits($name)];
  }

  public function getAllPatterns() {
    return iterator_to_array($this->getAllPatternsIterator());
  }

  public function getId() {
    return $this->name;
  }

  public function getLowercaseName() {
    return str_replace('-', ' ', $this->getNameWithoutDigits());
  }

  public function getName() {
    return $this->name;
  }

  public function getNameWithoutDigits() {
    return PatternLab::stripDigits($this->getName());
  }

  public function getPath() {
    return $this->getName();
  }

  /**
   * @return PatternInterface[]
   */
  public function getPatterns() {
    return iterator_to_array($this->getPatternsIterator());
  }

  /**
   * @param $name
   * @return PatternSubTypeInterface
   */
  public function getSubType($name) {
    return $this->items[$name];
  }

  /**
   * @return PatternSubTypeInterface[]
   */
  public function getSubTypes() {
    return iterator_to_array($this->getSubTypesIterator());
  }

  public function getUppercaseName() {
    return ucwords($this->getLowercaseName());
  }

  protected function ensureSubType($name) {
    if (!isset($this->items[$name])) $this->addItem($name, new PatternSubType($this, $name));
  }

  protected function getAllPatternsIterator() {
    $iterator = new \RecursiveIteratorIterator($this, \RecursiveIteratorIterator::SELF_FIRST);
    return new PatternFilterIterator($iterator, false);
  }

  protected function getPatternsIterator() {
    return new PatternFilterIterator($this);
  }

  protected function getSubTypesIterator() {
    return new SubTypeFilterIterator($this);
  }
}