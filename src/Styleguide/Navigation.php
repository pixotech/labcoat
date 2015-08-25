<?php

namespace Labcoat\Styleguide;

use Labcoat\PatternLabInterface;
use Labcoat\Styleguide\Navigation\Type;

class Navigation implements \JsonSerializable {

  /**
   * @var PatternLabInterface
   */
  protected $patternlab;

  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
  }

  public function getPatternTypes() {
    $types = [];
    foreach ($this->getTypes() as $type) {
      $types[] = new Type($type);
    }
    return $types;
  }

  public function jsonSerialize() {
    print_r($this->getPatternTypes());
    return [
      'patternTypes' => $this->getPatternTypes(),
    ];
  }

  /**
   * @return \Labcoat\Patterns\Type[]
   */
  protected function getTypes() {
    return $this->patternlab->getPatterns()->getTypes();
  }
}