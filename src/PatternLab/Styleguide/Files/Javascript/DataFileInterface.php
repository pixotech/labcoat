<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript;

use Labcoat\Generator\Files\FileInterface;

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