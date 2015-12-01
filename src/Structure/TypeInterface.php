<?php

namespace Labcoat\Structure;

interface TypeInterface extends FolderInterface {

  /**
   * @return SubtypeInterface[]
   */
  public function getSubtypes();

  /**
   * @return bool
   */
  public function hasSubtypes();
}