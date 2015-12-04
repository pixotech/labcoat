<?php

namespace Labcoat\Styleguide\Files;

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