<?php

namespace Labcoat\Styleguide\Navigation\Items;

use Labcoat\Patterns\PatternInterface as SourcePattern;
use Labcoat\Styleguide\Navigation\Items\Item;
use Labcoat\Styleguide\Navigation\Items\PatternItemInterface;

class PatternItem extends Item implements \JsonSerializable, PatternItemInterface {

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