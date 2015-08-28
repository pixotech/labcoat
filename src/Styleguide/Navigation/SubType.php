<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PatternSubTypeInterface;

class Subtype implements \JsonSerializable {

  protected $name;
  protected $patterns = [];
  protected $time = 0;

  public function __construct(PatternSubTypeInterface $subtype) {
    $this->name = $subtype->getName();
  }

  public function jsonSerialize() {
    return [
      'patternSubtypeLC' => $subType->getLowercaseName(),
      'patternSubtypeUC' => $subType->getUppercaseName(),
      'patternSubtype' => $subType->getName(),
      'patternSubtypeDash' => $subType->getNameWithoutDigits(),
      'patternSubtypeItems' => [],
    ];
  }

  public function addPattern(Pattern $pattern) {
    $this->patterns[$pattern->getName()] = $pattern;
    $this->time = max($this->time, $pattern->getTime());
  }

  public function getName() {
    return $this->name;
  }

  public function getTime() {
    return $this->time;
  }
}