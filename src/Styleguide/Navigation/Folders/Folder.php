<?php

namespace Labcoat\Styleguide\Navigation\Folders;

use Labcoat\Patterns\Paths\Segment;
use Labcoat\Structure\FolderInterface as SourceInterface;

abstract class Folder implements FolderInterface, \JsonSerializable {

  protected $folder;

  /**
   * @var array
   */
  protected $items = [];

  protected $typeItems = [];

  public function __construct(SourceInterface $folder) {
    $this->folder = $folder;
  }

  public function getItems() {
    return $this->items;
  }

  public function getLowercaseName() {
    return (new Segment($this->getName()))->normalize()->getName()->lowercase();
  }

  public function getName() {
    return $this->folder->getName();
  }

  public function getTypeItems() {
    return $this->typeItems;
  }

  public function getUppercaseName() {
    return (new Segment($this->getName()))->normalize()->getName()->capitalized();
  }

  public function hasTypeItems() {
    return !empty($this->typeItems);
  }

  public function jsonSerialize() {
    $json = [
      'patternType' => $this->getName(),
      'patternTypeLC' => $this->getLowercaseName(),
      'patternTypeUC' => $this->getUppercaseName(),
    ];
    if ($this->hasTypeItems()) {
      $json['patternTypeItems'] = $this->getTypeItems();
    }
    $json['patternItems'] = $this->getItems();
    return $json;
  }
}