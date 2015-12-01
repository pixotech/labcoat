<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Paths\Segment;
use Labcoat\Structure\SubtypeInterface as SourceInterface;

class Subtype implements \JsonSerializable, SubtypeInterface {

  protected $partial;
  protected $path;
  protected $patterns = [];
  protected $subtype;
  protected $type;

  public function __construct(SourceInterface $subtype) {
    $this->type = $subtype->getType()->getName();
    $this->subtype = $subtype->getName();
    $this->partial = Navigation::escapePath($subtype->getName());
    $this->path = Navigation::escapePath($subtype->getName());
  }

  public function jsonSerialize() {
    $items = array_values($this->patterns);
    if (!empty($items)) {
      $items[] = [
        "patternPath" => "{$this->path}/index.html",
        "patternName" => "View All",
        "patternType" => $this->type,
        "patternSubtype" => $this->subtype,
        "patternPartial" => "viewall-{$this->partial}",
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
    return $this->subtype;
  }

  public function getNameWithDashes() {
    return Segment::stripDigits($this->getName());
  }

  public function getUppercaseName() {
    return ucwords($this->getLowercaseName());
  }
}
