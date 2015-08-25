<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Patterns\Pattern;

class SubType extends ItemWithPatterns implements \JsonSerializable {

  /**
   * @var \Labcoat\Patterns\Type
   */
  protected $subType;

  public function __construct(\Labcoat\Patterns\SubType $subType) {
    $this->subType = $subType;
  }

  public function getLowercaseName() {
    return strtolower($this->getNameWithSpaces());
  }

  public function getName() {
    return $this->subType->getName();
  }

  public function getNameWithDashes() {
    return Pattern::stripOrdering($this->getName());
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