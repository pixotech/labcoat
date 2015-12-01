<?php

namespace Labcoat\Styleguide\Lineage;

use Labcoat\Styleguide\Patterns\PatternInterface;

class LineagePattern implements LineagePatternInterface, \JsonSerializable {

  /**
   * @var PatternInterface
   */
  protected $pattern;

  public function __construct(PatternInterface $pattern) {
    $this->pattern = $pattern;
  }

  public function getPartial() {
    return $this->pattern->getPartial();
  }

  public function getPath() {
    return $this->pattern->getLineagePath();
  }

  public function jsonSerialize() {
    return [
      'lineagePattern' => $this->getPartial(),
      'lineagePath' => $this->getPath(),
    ];
  }
}