<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\PatternLab;
use Labcoat\Patterns\PatternSubTypeInterface;

class Subtype implements \JsonSerializable, SubtypeInterface {

  protected $patterns = [];
  protected $subtype;
  protected $type;

  public function __construct(PatternSubTypeInterface $subtype) {
    #$this->subtype = $subtype;
    $this->name = $subtype->getName();
    $this->type = $subtype->getTypeId();
  }

  public function jsonSerialize() {
    $items = array_values($this->patterns);
    if (!empty($items)) {
      $type = PatternLab::stripDigits($this->type);
      $subtype = PatternLab::stripDigits($this->name);
      $items[] = [
        "patternPath" => "{$this->type}-{$this->name}/index.html",
        "patternName" => "View All",
        "patternType" => $this->type,
        "patternSubtype" => $this->name,
        "patternPartial" => "viewall-{$type}-{$subtype}",
      ];
    }
    return [
      'patternSubtypeLC' => $this->getLowercaseName(),
      'patternSubtypeUC' => $this->getUppercaseName(),
      'patternSubtype' => $this->getName(),
      'patternSubtypeDash' => $this->getNameWithDashes(),
      'patternSubtypeItems' => $items,
    ];
  }

  public function addPattern(\Labcoat\Patterns\PatternInterface $pattern) {
    $this->patterns[] = new Pattern($pattern);
  }

  public function getLowercaseName() {
    return str_replace('-', ' ', $this->getNameWithDashes());
  }

  public function getName() {
    return $this->name;
  }

  public function getNameWithDashes() {
    return PatternLab::stripDigits($this->getName());
  }

  public function getUppercaseName() {
    return ucwords($this->getLowercaseName());
  }
}