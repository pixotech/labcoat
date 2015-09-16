<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2015, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat\Styleguide;

use Labcoat\Styleguide\Patterns\PatternInterface;

interface StyleguideInterface {

  /**
   * Generate a style guide in the provided directory
   *
   * @param string $directory The destination for the new style guide
   */
  public function generate($directory);

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
   * Get the pattern with the provided ID
   *
   * @param string $id A pattern ID
   * @return PatternInterface A Pattern object
   */
  public function getPattern($id);

  /**
   * Get the Pattern Lab installation object used to make this style guide
   *
   * @return \Labcoat\PatternLabInterface A PatternLab object
   */
  public function getPatternLab();

  /**
   * Render a style guide template with the provided data
   *
   * @param string $template The name of the template
   * @param array $data An array of template variables
   * @return string Rendered template content
   */
  public function render($template, array $data = []);

  /**
   * Render the named pattern with the provided data
   *
   * @param \Labcoat\Styleguide\Patterns\PatternInterface $pattern The pattern object to render
   * @param array $data An array of template variables
   * @return string Rendered template content
   */
  public function renderPattern(PatternInterface $pattern, array $data = []);
}