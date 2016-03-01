<?php

namespace Labcoat\PatternLab\Styleguide\Types;

use Labcoat\PatternLab\PatternLab;
use Labcoat\PatternLab\Patterns\PatternInterface;

class Type implements TypeInterface {

  /**
   * @var string
   */
  protected $name;

  /**
   * @var PatternInterface[]
   */
  protected $patterns = [];

  protected $subtypes = [];

  protected $time;

  /**
   * @param string $name
   * @param PatternInterface[] $patterns
   */
  public function __construct($name, array $patterns = []) {
    $this->name = $name;
    if (!empty($patterns)) $this->addPatterns($patterns);
  }

  public function __toString() {
    return $this->getName();
  }

  /**
   * @param PatternInterface $pattern
   */
  public function addPattern(PatternInterface $pattern) {
    if ($pattern->hasSubtype()) $this->getOrCreateSubtype($pattern->getSubtype())->addPattern($pattern);
    else $this->patterns[] = $pattern;
  }

  public function addPatterns(array $patterns) {
    foreach ($patterns as $pattern) $this->addPattern($pattern);
  }

  public function count() {
    return count($this->patterns);
  }

  public function getId() {
    return $this->name;
  }

  public function getLabel() {
    return PatternLab::makeLabel($this->name);
  }

  public function getName() {
    return PatternLab::stripOrdering($this->name);
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

  public function getPartial() {
    return 'viewall-' . $this->getName() . '-all';
  }

  /**
   * @param $name
   * @return SubtypeInterface
   */
  public function getSubtype($name) {
    return $this->subtypes[$name];
  }

  /**
   * @return SubtypeInterface[]
   */
  public function getSubTypes() {
    return $this->subtypes;
  }

  /**
   * @return bool
   */
  public function hasSubtypes() {
    return count($this->subtypes) > 0;
  }

  /**
   * @param string $name
   * @return SubtypeInterface
   */
  protected function getOrCreateSubtype($name) {
    if (!isset($this->subtypes[$name])) $this->subtypes[$name] = new Subtype($this, $name);
    return $this->subtypes[$name];
  }
}