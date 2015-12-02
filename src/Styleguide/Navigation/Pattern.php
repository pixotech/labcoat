<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Patterns\PatternInterface as SourcePattern;

class Pattern extends Item implements \JsonSerializable, PatternInterface {

  /**
   * @var SourcePattern
   */
  protected $pattern;

  public function __construct(SourcePattern $pattern) {
    $this->pattern = $pattern;
  }

  public function getName() {
    if (!$this->pattern->getPath()) return null;
    return $this->pattern->getPath()->normalize()->getName()->capitalized();
  }

  public function getPartial() {
    return $this->pattern->getPartial();
  }

  public function getPath() {
    $name = $this->pattern->getPath()->join('-');
    return "{$name}/{$name}.html";
  }

  public function getState() {
    return $this->pattern->getState();
  }

  public function jsonSerialize() {
    return parent::jsonSerialize() + [
      'patternState' => $this->getState(),
    ];
  }
}