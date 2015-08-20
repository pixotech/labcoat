<?php

namespace Labcoat\Patterns;

class PatternCollection implements PatternCollectionInterface, \Countable, \IteratorAggregate {

  /**
   * @var string[]
   */
  protected $matches = [];

  /**
   * @var Pattern[]
   */
  protected $patterns = [];

  /**
   * @var Pattern[]
   */
  protected $patternsByShorthand = [];

  public function add(PatternInterface $pattern) {
    $template = $pattern->getTemplate();
    $this->patterns[$template] = $pattern;
    $shorthand = $pattern->getShorthand();
    if (isset($this->patternsByShorthand[$shorthand])) {
      $existing = $this->patternsByShorthand[$shorthand];
      if (strcmp($template, $existing->getTemplate()) < 0) {
        $this->patternsByShorthand[$shorthand] = $this->patterns[$template];
      }
    }
    else {
      $this->patternsByShorthand[$shorthand] = $this->patterns[$template];
    }
    ksort($this->patterns);
    ksort($this->patternsByShorthand);
  }

  /**
   * @return Pattern[]
   */
  public function all() {
    return $this->patterns;
  }

  public function count() {
    return count($this->patterns);
  }

  public function getIterator() {
    return new \ArrayIterator($this->patterns);
  }

  /**
   * @param $name
   * @return Pattern
   * @throws \OutOfBoundsException
   */
  public function get($name) {
    if (isset($this->patterns[$name])) {
      return $this->patterns[$name];
    }
    if (isset($this->patternsByShorthand[$name])) {
      return $this->patternsByShorthand[$name];
    }
    if (isset($this->matches[$name])) {
      return $this->patterns[$this->matches[$name]];
    }
    foreach ($this->all() as $key => $pattern) {
      if ($pattern->matches($name)) {
        $this->matches[$name] = $key;
        return $pattern;
      }
    }
    throw new \OutOfBoundsException("Unknown pattern: $name");
  }
}