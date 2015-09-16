<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2015, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat;

interface HasItemsInterface extends \RecursiveIterator {

  /**
   * Get the number of items
   *
   * @return int
   */
  public function count();
}