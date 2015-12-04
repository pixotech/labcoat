<?php

namespace Labcoat\Styleguide\Files;

interface DataFileInterface extends FileInterface {

  /**
   * @return array
   */
  public function getNavItems();
}