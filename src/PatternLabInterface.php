<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2016, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat;

use Labcoat\Data\DataInterface;
use Labcoat\PatternLab\Styleguide\Patterns\PatternInterface;

interface PatternLabInterface {

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

  public function render(PatternInterface $pattern, DataInterface $data = null);
}