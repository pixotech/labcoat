<?php

namespace Labcoat\Styleguide\Navigation\Items;

use Labcoat\Styleguide\Navigation\Folders\FolderInterface;
use Labcoat\Styleguide\Navigation\Folders\SubtypeInterface;
use Labcoat\Styleguide\Navigation\Items\Item;
use Labcoat\Styleguide\Navigation\Items\TypeItemInterface;

class TypeItem extends Item implements TypeItemInterface {

  protected $folder;

  public function __construct(FolderInterface $folder) {
    $this->folder = $folder;
  }

  public function getName() {
    return 'View All';
  }

  public function getPath() {
    return implode('/', [$this->getName(), 'index.html']);
  }

  public function getPartial() {
    return implode('-', ['viewall', $this->getType(), $this->getSubtype()]);
  }

  public function getSubtype() {
    if ($this->isSubtype()) {

    }
    else {
      return 'all';
    }
  }

  public function getType() {
    if ($this->isSubtype()) {

    }
    else {
      return $this->folder;
    }
  }

  public function jsonSerialize() {
    return [
      "patternPath" => $this->getPath(),
      "patternName" => $this->getName(),
      "patternType" => $this->getType(),
      "patternSubtype" => $this->getSubtype(),
      "patternPartial" => $this->getPartial(),
    ];
  }

  protected function isSubtype() {
    return $this->folder instanceof SubtypeInterface;
  }
}