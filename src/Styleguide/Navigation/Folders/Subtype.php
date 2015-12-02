<?php

namespace Labcoat\Styleguide\Navigation\Folders;

use Labcoat\Structure\SubtypeInterface as SourceInterface;
use Labcoat\Styleguide\Navigation\Navigation;
use Labcoat\Styleguide\Navigation\Pattern;
use Labcoat\Styleguide\Navigation\TypeItem;

class Subtype extends Folder implements \JsonSerializable, SubtypeInterface {

  public function __construct(SourceInterface $subtype) {
    parent::__construct($subtype);
    foreach ($subtype->getPatterns() as $pattern) $this->items[] = new Pattern($pattern);
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
    return str_replace('-', ' ', $this->getNameWithDashes());
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
