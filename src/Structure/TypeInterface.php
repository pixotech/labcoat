<?php

namespace Labcoat\Structure;

interface TypeInterface extends FolderInterface {

  /**
   * @return bool
   */
  public function hasSubtypes();
}