<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2016, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat;

use Labcoat\Configuration\ConfigurationInterface;
use Labcoat\Configuration\LabcoatConfiguration;
use Labcoat\Configuration\StandardEditionConfiguration;
use Labcoat\PatternLab\Pattern;
use Labcoat\PatternLab\Styleguide\Patterns\Path;

class PatternLab implements PatternLabInterface {

  /**
   * @var \Labcoat\PatternLab\PatternInterface[]
   */
  protected $patterns;

  /**
   * Is this a partial name?
   *
   * Labcoat assumes that a name is a partial if it doesn't contain a slash
   *
   * @param string $name The name of the pattern
   * @return bool True if the name is a path; otherwise, false
   */
  public static function isPartialName($name) {
    return false === strpos($name, '/');
  }

  /**
   * Is this a path?
   *
   * Labcoat assumes that a name is a path if it contains a slash
   *
   * @param string $name The name of the pattern
   * @return bool True if the name is a path; otherwise, false
   */
  public static function isPathName($name) {
    return false !== strpos($name, DIRECTORY_SEPARATOR);
  }

  /**
   * Load a Pattern Lab installation that uses the default Labcoat file structure
   *
   * @param string $dir The path to the Pattern Lab installation
   * @return PatternLab A new PatternLab object
   */
  public static function load($dir) {
    $config = new LabcoatConfiguration($dir);
    return new PatternLab($config);
  }

  /**
   * Load a Pattern Lab installation that uses the Standard Edition file structure
   *
   * @param string $dir The path to the Pattern Lab installation
   * @return PatternLab A new PatternLab object
   */
  public static function loadStandardEdition($dir) {
    $config = new StandardEditionConfiguration($dir);
    return new PatternLab($config);
  }

  /**
   * Make a path string from an array of segments
   *
   * @param array $segments An array of path segments
   * @return string A path
   */
  public static function makePath(array $segments) {
    return implode('/', $segments);
  }

  /**
   * Normalize a template path
   *
   * Normalization invokes:
   * - Removing all ordering digits
   * - Replace all slashes with a forward slash
   *
   * @param string $path The raw path
   * @return string The normalized path
   */
  public static function normalizePath($path) {
    return (string)(new Path($path))->normalize();
  }


  /**
   * Constructor
   *
   * @param \Labcoat\Configuration\ConfigurationInterface $config A configuration object
   */
  public function __construct(ConfigurationInterface $config) {
    $this->findPatterns($config->getPatternsDirectory(), $config->getPatternExtension());
  }

  /**
   * {@inheritdoc}
   */
  public function getPatterns() {
    return $this->patterns;
  }

  /**
   * Look in the pattern directory for pattern templates
   */
  protected function findPatterns($dir, $ext) {
    foreach ($this->getPatternFilesIterator($dir, $ext) as $match => $file) {
      $path = substr($match, strlen($dir) + 1, -1 - strlen($ext));
      $this->patterns[] = Pattern::makeFromFile($dir, $path, $ext);
    }
  }

  protected function getPatternFilesIterator($dir, $ext) {
    $flags = \FilesystemIterator::SKIP_DOTS;
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, $flags));
    $regex = '|\.' . preg_quote($ext) . '$|';
    return new \RegexIterator($files, $regex, \RegexIterator::MATCH);
  }

  /**
   * Remove the template extension from a path
   *
   * @param string $path The template path with extension
   * @return string The path with the extension removed
   */
  protected function stripPatternExtensionFromPath($path, $ext) {
    if (substr($path, 0 - strlen($ext)) == $ext) $path = substr($path, 0, 0 - strlen($ext));
    return $path;
  }
}
