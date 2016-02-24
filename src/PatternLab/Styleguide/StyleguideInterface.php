<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2015, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\PatternLab\Styleguide;

use Labcoat\PatternLab\PatternInterface;

interface StyleguideInterface {

  /**
   * @param $pattern
   */
  public function addPattern(PatternInterface $pattern);

  /**
   * Generate a style guide in the provided directory
   *
   * @param string $directory The destination for the new style guide
   */
  public function generate($directory);

  /**
   * @return string
   */
  public function getAnnotationsFilePath();

  /**
   * Get the cache-busting string
   *
   * This string is added to some asset URLs to prevent stale file copies from being served
   *
   * @return string The cache-busting string
   */
  public function getCacheBuster();

  /**
   * Get the array of global pattern variables
   *
   * @return array An array of global variables
   */
  public function getGlobalData();

  /**
   * @return array
   */
  public function getHiddenControls();

  /**
   * Maximum size for the viewport resizer
   *
   * @return int
   */
  public function getMaximumWidth();

  /**
   * Minimum size for the viewport resizer
   *
   * @return int
   */
  public function getMinimumWidth();

  /**
   * Get the path to the style guide footer template
   *
   * @return string The template path
   */
  public function getPatternFooterTemplatePath();

  /**
   * Get the path to the style guide header template
   *
   * @return string The template path
   */
  public function getPatternHeaderTemplatePath();

  /**
   * @return Types\TypeInterface[]
   */
  public function getTypes();

  public function setAnnotationsFilePath($path);

  public function setGlobalData($data);

  public function setHiddenControls(array $controls);

  public function setPatternFooterTemplatePath($path);

  public function setPatternHeaderTemplatePath($path);
}