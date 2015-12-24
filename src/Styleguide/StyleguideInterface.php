<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2016, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\Styleguide;

interface StyleguideInterface {


  /**
   * Generate a style guide in the provided directory
   *
   * @param string $directory The destination for the new style guide
   */
  public function generate($directory);
}