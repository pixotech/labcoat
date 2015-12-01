<?php

namespace Labcoat\Structure;

interface SubtypeInterface extends FolderInterface {

  /**
   * @return TypeInterface
   */
  public function getType();
}