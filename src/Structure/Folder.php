<?php

namespace Labcoat\Structure;

use Labcoat\Patterns\PatternInterface;

abstract class Folder implements \Countable, FolderInterface {

  /**
   * @var string
   */
  protected $name;

  /**
   * @var PatternInterface[]
   */
  protected $patterns = [];

  protected $time;

  /**
   * @param string $name
   * @param PatternInterface[] $patterns
   */
  public function __construct($name, array $patterns = []) {
    $this->name = $name;
    if (!empty($patterns)) $this->addPatterns($patterns);
  }

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
  }

  public function addPatterns(array $patterns) {
    foreach ($patterns as $pattern) $this->addPattern($pattern);
  }

  public function count() {
    return count($this->patterns);
  }

  public function getName() {
    return $this->name;
  }

  /**
   * @return PatternInterface[]
   */
  public function getPatterns() {
    return $this->patterns;
  }

  public function getTime() {
    if (!isset($this->time)) {
      $this->time = 0;
      foreach ($this->getPatterns() as $pattern) {
        $time = $pattern->getTime();
        if ($time > $this->time) $this->time = $time;
      }
    }
    return $this->time;
  }
}