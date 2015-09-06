<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\PatternLab;
use Labcoat\Sections\SubtypeInterface as SourceInterface;

class Subtype implements \JsonSerializable, SubtypeInterface {

  protected $partial;
  protected $path;
  protected $patterns = [];
  protected $subtype;
  protected $type;

  public function __construct(SourceInterface $subtype) {
    list ($this->type, $this->subtype) = explode('/', $subtype->getPath());
    $this->partial = Navigation::escapePath($subtype->getNormalizedPath());
    $this->path = Navigation::escapePath($subtype->getPath());
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
    return PatternLab::stripDigits($this->getName());
  }

  public function getUppercaseName() {
    return ucwords($this->getLowercaseName());
  }
}