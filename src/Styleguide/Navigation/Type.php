<?php

namespace Labcoat\Styleguide\Navigation;

class Type implements \JsonSerializable {

  protected $patterns = [];
  protected $subtypes = [];
  protected $time = 0;

  public function jsonSerialize() {
    return [
      'patternTypeLC' => $type->getLowercaseName(),
      'patternTypeUC' => $type->getUppercaseName(),
      'patternType' => $type->getName(),
      'patternTypeDash' => $type->getNameWithoutDigits(),
      'patternTypeItems' => [],
      'patternItems' => [],
    ];
  }

  public function addPattern(Pattern $pattern) {
    $this->patterns[$pattern->getName()] = $pattern;
    $this->time = max($this->time, $pattern->getTime());
  }

  public function addSubtype(Subtype $subtype) {
    $this->subtypes[$subtype->getName()] = $subtype;
  }

  public function getSubtype($name) {
    return $this->subtypes[$name];
  }
}