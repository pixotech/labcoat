<?php

namespace Labcoat\PatternLab\Patterns\Types;

use Labcoat\PatternLab\Patterns\Pattern;
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

  /**
   * @var Subtype[]
   */
  protected $subtypes = [];

  /**
   * @param string $name
   */
  public function __construct($name) {
    $this->name = $name;
  }

  public function __toString() {
    return $this->getName();
  }

  /**
   * @param PatternInterface $pattern
   */
  public function addPattern(PatternInterface $pattern) {
    if ($pattern->hasSubtype()) $this->getOrCreateSubtype($pattern->getSubtype())->addPattern($pattern);
    else $this->patterns[$pattern->getName()] = $pattern;
  }

  /**
   * @return string
   */
  public function getLabel() {
    return Pattern::makeLabel($this->name);
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getNameWithoutOrdering() {
    return Pattern::stripOrdering($this->getName());
  }

  /**
   * @return PatternInterface[]
   */
  public function getPatterns() {
    return $this->patterns;
  }

  /**
   * @return string
   */
  public function getPartial() {
    return 'viewall-' . $this->getNameWithoutOrdering() . '-all';
  }

  /**
   * @return Subtype[]
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
   * @return Subtype
   */
  protected function getOrCreateSubtype($name) {
    if (!isset($this->subtypes[$name])) $this->subtypes[$name] = new Subtype($this, $name);
    return $this->subtypes[$name];
  }
}