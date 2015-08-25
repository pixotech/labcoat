<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2015, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\Assets;

interface AssetInterface {

  /**
   * Get the full path to the asset file
   *
   * @return string
   */
  public function getFile();

  /**
   * Get the relative asset path
   *
   * This path is relative to the Pattern Lab source directory
   *
   * @return string
   */
  public function getPath();
}