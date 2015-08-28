<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\PatternLab;
use Labcoat\Patterns\Pattern;

class SubType extends ItemWithPatterns implements \JsonSerializable {

  /**
   * @var \Labcoat\Patterns\PatternType
   */
  protected $subType;

  public function __construct(\Labcoat\Patterns\PatternSubType $subType) {
    $this->subType = $subType;
  }

  public function getLowercaseName() {
    return strtolower($this->getNameWithSpaces());
  }

  public function getName() {
    return $this->subType->getName();
  }

  public function getNameWithDashes() {
    return PatternLab::stripDigits($this->getName());
  }

  public function getNameWithSpaces() {
    return str_replace('-', ' ', $this->getNameWithDashes());
  }

  public function getUppercaseName() {
    return ucwords($this->getNameWithSpaces());
  }

  public function jsonSerialize() {
    return [
      "patternSubtypeLC" => $this->getLowercaseName(),
      "patternSubtypeUC" => $this->getUppercaseName(),
      "patternSubtype" => $this->getName(),
      "patternSubtypeDash" => $this->getNameWithDashes(),
      "patternSubtypeItems" => $this->getItems(),
    ];
  }

  protected function getPatterns() {
    return $this->subType->getPatterns();
  }
}