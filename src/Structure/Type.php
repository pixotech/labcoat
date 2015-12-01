<?php

namespace Labcoat\Structure;

use Labcoat\Patterns\PatternInterface;

class Type extends Folder implements TypeInterface {

  protected $subtypes = [];

  /**
   * @param PatternInterface $pattern
   */
  public function addPattern(PatternInterface $pattern) {
    if ($pattern->hasSubtype()) $this->getOrCreateSubtype($pattern->getSubtype())->addPattern($pattern);
    else parent::addPattern($pattern);
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
   * @param $name
   * @return SubtypeInterface
   */
  protected function getOrCreateSubtype($name) {
    if (!isset($this->subtypes[$name])) $this->subtypes[$name] = new Subtype($this, $name);
    return $this->subtypes[$name];
  }
}