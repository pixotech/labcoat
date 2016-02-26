<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2016, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat;

interface PatternLabInterface {

  /**
   * @return \Labcoat\PatternLab\Patterns\PatternInterface[]
   */
  public function getPatterns();

  /**
   * @return \Labcoat\PatternLab\Styleguide\StyleguideInterface
   */
  public function getStyleguide();
}