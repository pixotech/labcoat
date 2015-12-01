<?php

namespace Labcoat\Mocks\Structure;

use Labcoat\Structure\FolderInterface;

class Folder extends \Labcoat\Structure\Folder implements FolderInterface {

  public $name;
  public $patterns = [];
}