<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\PatternLab;
use Labcoat\Patterns\Pattern;

class Type extends ItemWithPatterns implements \JsonSerializable {

  /**
   * @var \Labcoat\Patterns\PatternType
   */
  protected $type;

  public function __construct(\Labcoat\Patterns\PatternType $type) {
    $this->type = $type;
  }

  public function getLowercaseName() {
    return strtolower($this->getNameWithSpaces());
  }

  public function getName() {
    return $this->type->getName();
  }

  public function getNameWithDashes() {
    return PatternLab::stripOrdering($this->getName());
  }

  public function getNameWithSpaces() {
    return str_replace('-', ' ', $this->getNameWithDashes());
  }

  public function getSubTypes() {
    $subTypes = [];
    foreach ($this->type->getSubTypes() as $subType) {
      $subTypes[] = new SubType($subType);
    }
    return $subTypes;
  }

  public function getUppercaseName() {
    return ucwords($this->getNameWithSpaces());
  }

  public function jsonSerialize() {
    return [
      "patternTypeLC" => $this->getLowercaseName(),
      "patternTypeUC" => $this->getUppercaseName(),
      "patternType" => $this->getName(),
      "patternTypeDash" => $this->getNameWithDashes(),
      "patternTypeItems" => $this->getSubTypes(),
      "patternItems" => $this->getItems(),
    ];
  }

  protected function getPatterns() {
    return $this->type->getPatterns();
  }
}