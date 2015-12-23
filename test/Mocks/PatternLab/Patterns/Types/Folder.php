<?php

namespace Labcoat\Mocks\PatternLab\Patterns\Types;

use Labcoat\PatternLab\Patterns\Types\FolderInterface;

class Folder extends \Labcoat\PatternLab\Patterns\Types\Folder implements FolderInterface {

  public $folder;
  public $patterns = [];

  public function getId() {
    // TODO: Implement getId() method.
  }

  public function getLabel() {
    // TODO: Implement getLabel() method.
  }

  public function getPagePath() {
    // TODO: Implement getPagePath() method.
  }

  public function getPartial() {
    // TODO: Implement getPartial() method.
  }
}