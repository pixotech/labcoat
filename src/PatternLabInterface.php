<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2015, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat;

interface PatternLabInterface {

  /**
   * Get the path to the annotations file
   *
   * @return string The file path
   */
  public function getAnnotationsFile();

  /**
   * Get an array of asset files
   *
   * @return \Labcoat\Assets\AssetInterface[] An array of asset objects
   */
  public function getAssets();

  /**
   * Get the global variables used for all patterns
   *
   * @return array The global pattern variables
   */
  public function getGlobalData();

  /**
   * Get a list of interface controls to hide
   *
   * @return array An array of controls to hide
   */
  public function getHiddenControls();

  /**
   * Get a list of asset directories to ignore
   *
   * @return array An array of path segments
   */
  public function getIgnoredDirectories();

  /**
   * Get a list of asset extensions to ignore
   *
   * @return array An array of file extensions
   */
  public function getIgnoredExtensions();

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
   * @return \Labcoat\Patterns\PatternInterface[] An array of pattern objects
   */
  public function getPatterns();

  /**
   * Get the paths to style guide asset directories
   *
   * @return array An array of directory paths
   */
  public function getStyleguideAssetDirectories();

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
   * Get the path to the style guide templates
   *
   * @return string The path to the templates directory
   */
  public function getStyleguideTemplatesDirectory();

  /**
   * @return \Labcoat\Structure\TypeInterface[]
   */
  public function getTypes();

  /**
   * Does this asset path have an ignored extension?
   *
   * @param string $path Path to an asset file
   * @return bool True if the path has an ignored extension
   */
  public function hasIgnoredExtension($path);

  /**
   * Is this the path to a hidden asset?
   *
   * @param string $path Path to an asset file
   * @return bool True if the asset is hidden
   */
  public function isHiddenFile($path);

  /**
   * Is this an ignored asset path?
   *
   * @param string $path Path to an asset file
   * @return bool True if the asset should be ignored
   */
  public function isIgnoredFile($path);

  /**
   * Is this asset path in an ignored directory?
   *
   * @param string $path Path to an asset file
   * @return bool True if the asset is in an ignored directory
   */
  public function isInIgnoredDirectory($path);
}