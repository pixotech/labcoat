<?php

namespace Labcoat\Mocks\Structure;

use Labcoat\Structure\FolderInterface;

class Folder extends \Labcoat\Structure\Folder implements FolderInterface {

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