<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2016, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\PatternLab\Styleguide;

use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\Types\TypeInterface;

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
   * @param PatternInterface $pattern
   * @return string
   */
  public function getPatternDirectoryName(PatternInterface $pattern);

  /**
   * @return array
   */
  public function getScripts();

  /**
   * @return array
   */
  public function getStylesheets();

  /**
   * @param TypeInterface $type
   * @return string
   */
  public function getTypeDirectoryName(TypeInterface $type);

  /**
   * @return Types\TypeInterface[]
   */
  public function getTypes();
}