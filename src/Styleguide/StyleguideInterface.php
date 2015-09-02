<?php

namespace Labcoat\Styleguide;

use Labcoat\Styleguide\Patterns\PatternInterface;

interface StyleguideInterface {

  /**
   * @param string $directory
   */
  public function generate($directory);

  /**
   * @return string
   */
  public function getCacheBuster();

  /**
   * @return array
   */
  public function getConfig();

  /**
   * @return array
   */
  public function getControls();

  /**
   * @return array
   */
  public function getIndexPaths();

  /**
   * @return string
   */
  public function getPatternContent(PatternInterface $pattern);

  /**
   * @return array
   */
  public function getPatternPaths();

  /**
   * @return array
   */
  public function getPlugins();
}