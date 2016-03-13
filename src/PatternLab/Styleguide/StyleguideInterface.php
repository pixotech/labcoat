<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2016, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\PatternLab\Styleguide;

use Labcoat\PatternLab\Patterns\PatternInterface;

interface StyleguideInterface {

  /**
   * @param PatternInterface $pattern
   */
  public function addPattern(PatternInterface $pattern);

  /**
   * @return array
   */
  public function getBreakpoints();

  /**
   * @return string
   */
  public function getCacheBuster();

  /**
   * @return array
   */
  public function getHiddenControls();

  /**
   * @return int
   */
  public function getMaximumWidth();

  /**
   * @return int
   */
  public function getMinimumWidth();

  /**
   * @return array
   */
  public function getScripts();

  /**
   * @return array
   */
  public function getStylesheets();

  /**
   * @return Types\TypeInterface[]
   */
  public function getTypes();
}