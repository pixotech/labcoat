<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\PatternLab;
use Labcoat\Patterns\PatternSubTypeInterface;

class Subtype implements \JsonSerializable, SubtypeInterface {

  protected $patterns = [];
  protected $subtype;

  public function __construct(PatternSubTypeInterface $subtype) {
    $this->subtype = $subtype;
  }

  public function jsonSerialize() {
    return [
      'patternSubtypeLC' => $this->getLowercaseName(),
      'patternSubtypeUC' => $this->getUppercaseName(),
      'patternSubtype' => $this->getName(),
      'patternSubtypeDash' => $this->getNameWithDashes(),
      'patternSubtypeItems' => [],
    ];
  }

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[$pattern->getName()] = $pattern;
  }

  public function getLowercaseName() {
    return str_replace('-', ' ', $this->getNameWithDashes());
  }

  public function getName() {
    return $this->subtype->getName();
  }

  public function getNameWithDashes() {
    return PatternLab::stripDigits($this->getName());
  }

  public function getUppercaseName() {
    return ucwords($this->getLowercaseName());
  }
}