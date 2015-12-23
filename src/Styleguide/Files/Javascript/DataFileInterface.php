<?php

namespace Labcoat\Styleguide\Files\Javascript;

use Labcoat\Styleguide\Files\FileInterface;

interface DataFileInterface extends FileInterface {

  /**
   * @return array
   */
  public function getNavItems();

  /**
   * @return array
   */
  public function getPatternPaths();

  /**
   * @return array
   */
  public function getViewAllPaths();
}