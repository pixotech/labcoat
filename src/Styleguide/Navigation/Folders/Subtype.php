<?php

namespace Labcoat\Styleguide\Navigation\Folders;

use Labcoat\Patterns\Paths\Segment;
use Labcoat\Structure\SubtypeInterface as SourceInterface;
use Labcoat\Styleguide\Navigation\Navigation;
use Labcoat\Styleguide\Navigation\Items\PatternItem;
use Labcoat\Styleguide\Navigation\Items\TypeItem;

class Subtype extends Folder implements \JsonSerializable, SubtypeInterface {

  public function __construct(SourceInterface $subtype) {
    parent::__construct($subtype);
    foreach ($subtype->getPatterns() as $pattern) $this->items[] = new PatternItem($pattern);
  }

  public function jsonSerialize() {
    $items = array_values($this->getPatterns());
    if (!empty($items)) {
      $items[] = new TypeItem($this);
    }
    return [
      'patternSubtypeLC' => $this->getLowercaseName(),
      'patternSubtypeUC' => $this->getUppercaseName(),
      'patternSubtype' => $this->getName(),
      'patternSubtypeItems' => $items,
    ];
  }

  public function getLowercaseName() {
    return (new Segment($this->folder->getName()))->getName()->lowercase();
  }

  public function getPartial() {
    return Navigation::escapePath($this->name);
  }

  public function getPath() {
    return Navigation::escapePath($this->name);
  }

  public function getPatterns() {
    return $this->items;
  }

  public function getUppercaseName() {
    return ucwords($this->getLowercaseName());
  }
}
