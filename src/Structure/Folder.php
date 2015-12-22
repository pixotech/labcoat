<?php

namespace Labcoat\Structure;

use Labcoat\PatternLab\Name;
use Labcoat\Patterns\PatternInterface;

abstract class Folder implements \Countable, FolderInterface {

  /**
   * @var string
   */
  protected $id;

  /**
   * @var Name
   */
  protected $name;

  /**
   * @var PatternInterface[]
   */
  protected $patterns = [];

  protected $time;

  /**
   * @param string $id
   * @param PatternInterface[] $patterns
   */
  public function __construct($id, array $patterns = []) {
    $this->id = $id;
    $this->name = new Name($id);
    if (!empty($patterns)) $this->addPatterns($patterns);
  }

  public function __toString() {
    return (string)$this->name;
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

  public function getLabel() {
    return $this->name->capitalized();
  }

  public function getName() {
    return (string)$this->name;
  }

  public function getPagePath() {
    $id = $this->getId();
    return "{$id}/index.html";
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