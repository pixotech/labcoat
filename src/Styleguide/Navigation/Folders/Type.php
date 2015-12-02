<?php

namespace Labcoat\Styleguide\Navigation\Folders;

use Labcoat\Structure\TypeInterface as SourceTypeInterface;
use Labcoat\Styleguide\Navigation\Pattern;
use Labcoat\Styleguide\Navigation\TypeItem;

class Type extends Folder implements \JsonSerializable, TypeInterface {

  public function __construct(SourceTypeInterface $type) {
    parent::__construct($type);
    foreach ($type->getSubtypes() as $subtype) $this->typeItems[] = new Subtype($subtype);
    foreach ($type->getPatterns() as $pattern) $this->items[] = new Pattern($pattern);
  }

  public function getItems() {
    $items = parent::getItems();
    if (!empty($this->typeItems)) $items[] = new TypeItem($this);
    return $items;
  }

  public function jsonSerialize() {
    return [
      'patternTypeLC' => $this->getLowercaseName(),
      'patternTypeUC' => $this->getUppercaseName(),
      'patternType' => $this->getName(),
      'patternTypeItems' => $this->getTypeItems(),
      'patternItems' => $this->getItems(),
    ];
  }
}
