<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2015, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat;

use Labcoat\Data\DataInterface;
use Labcoat\PatternLab\Styleguide\Patterns\PatternInterface;

interface PatternLabInterface {

  /**
   * Get the path to the annotations file
   *
   * @return string The file path
   */
  public function getAnnotationsFile();

  /**
   * Get the global variables used for all patterns
   *
   * @return \Labcoat\Data\DataInterface The global pattern variables
   */
  public function getGlobalData();

  /**
   * Get a list of interface controls to hide
   *
   * @return array An array of controls to hide
   */
  public function getHiddenControls();

  /**
   * Get the extension for pattern template files
   *
   * @return string The template extension
   */
  public function getPatternExtension();

  /**
   * Get the path to the pattern templates directory
   *
   * @return string The path to the templates directory
   */
  public function getPatternsDirectory();

  /**
   * Get all patterns
   *
   * @return \Labcoat\PatternLab\Styleguide\Patterns\PatternInterface[] An array of pattern objects
   */
  public function getPatterns();

  public function getPatternsThatInclude(PatternInterface $pattern);

  /**
   * Get the path to the style guide footer template
   *
   * @return string The template path
   */
  public function getStyleguideFooter();

  /**
   * Get the path to the style guide header template
   *
   * @return string The template path
   */
  public function getStyleguideHeader();

  /**
   * @return \Labcoat\PatternLab\Styleguide\Patterns\Types\TypeInterface[]
   */
  public function getTypes();

  /**
   * @return bool
   */
  public function hasStyleguideFooter();

  /**
   * @return bool
   */
  public function hasStyleguideHeader();

  public function render(PatternInterface $pattern, DataInterface $data = null);
}