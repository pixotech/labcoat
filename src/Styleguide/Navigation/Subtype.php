<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Patterns\Paths\Segment;
use Labcoat\Structure\SubtypeInterface as SourceInterface;

class Subtype implements \JsonSerializable, SubtypeInterface {

  protected $name;
  protected $patterns = [];
  protected $type;

  public function __construct(SourceInterface $subtype) {
    $this->type = $subtype->getType()->getName();
    $this->name = $subtype->getName();
    foreach ($subtype->getPatterns() as $pattern) $this->patterns[] = new Pattern($pattern);
  }

  public function jsonSerialize() {
    $items = array_values($this->patterns);
    if (!empty($items)) {
      $items[] = [
        "patternPath" => $this->getPath() . "/index.html",
        "patternName" => "View All",
        "patternType" => $this->type,
        "patternSubtype" => $this->name,
        "patternPartial" => "viewall-" . $this->getPartial(),
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

  public function getLowercaseName() {
    return str_replace('-', ' ', $this->getNameWithDashes());
  }

  public function getName() {
    return $this->name;
  }

  public function getNameWithDashes() {
    return Segment::stripDigits($this->getName());
  }

  public function getPartial() {
    return Navigation::escapePath($this->name);
  }

  public function getPath() {
    return Navigation::escapePath($this->name);
  }

  public function getPatterns() {
    return $this->patterns;
  }

  public function getUppercaseName() {
    return ucwords($this->getLowercaseName());
  }
}
