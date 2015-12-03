<?php

namespace Labcoat\Structure;

use Labcoat\Patterns\Paths\SegmentInterface;
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

  public function getId() {
    return $this->name;
  }

  public function getPartial() {
    // TODO: Implement getPartial() method.
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
   * @param SegmentInterface $name
   * @return SubtypeInterface
   */
  protected function getOrCreateSubtype(SegmentInterface $name) {
    $name = (string)$name;
    if (!isset($this->subtypes[$name])) $this->subtypes[$name] = new Subtype($this, $name);
    return $this->subtypes[$name];
  }
}