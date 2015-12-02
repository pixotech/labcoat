<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Patterns\Paths\Segment;
use Labcoat\Structure\TypeInterface as SourceTypeInterface;

class Type implements \JsonSerializable, TypeInterface {

  protected $name;
  protected $patterns = [];
  protected $subtypes = [];

  public function __construct(SourceTypeInterface $type) {
    $this->name = $type->getName();
    foreach ($type->getSubtypes() as $subtype) $this->subtypes[] = new Subtype($subtype);
    foreach ($type->getPatterns() as $pattern) $this->patterns[] = new Pattern($pattern);
  }

  public function getIndex() {
    $type = Segment::stripDigits($this->name);
    return [
      "patternPath" => "{$this->name}/index.html",
      "patternName" => "View All",
      "patternType" => $this->name,
      "patternSubtype" => "all",
      "patternPartial" => "viewall-{$type}-all",
    ];
  }

  public function getItems() {
    $items = array_values($this->patterns);
    if (!empty($this->subtypes)) $items[] = $this->getIndex();
    return $items;
  }

  public function getLowercaseName() {
    return $this->getSegmentName()->lowercase();
  }

  public function getName() {
    return $this->name;
  }

  /**
   * @return PatternInterface[]
   */
  public function getPatterns() {
    return $this->patterns;
  }

  /**
   * @return SubtypeInterface[]
   */
  public function getSubtypes() {
    return $this->subtypes;
  }

  public function getUppercaseName() {
    return $this->getSegmentName()->capitalized();
  }

  public function jsonSerialize() {
    return [
      'patternTypeLC' => $this->getLowercaseName(),
      'patternTypeUC' => $this->getUppercaseName(),
      'patternType' => $this->name,
      'patternTypeItems' => array_values($this->subtypes),
      'patternItems' => $this->getItems(),
    ];
  }

  public function hasSubtypes() {
    return !empty($this->subtypes);
  }

  protected function getSegmentName() {
    return (new Segment($this->name))->normalize()->getName();
  }
}
