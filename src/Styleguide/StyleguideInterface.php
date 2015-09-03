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
   * @return array
   */
  public function getPatternData(PatternInterface $pattern);

  /**
   * @return array
   */
  public function getPatternPaths();

  /**
   * @return array
   */
  public function getPlugins();

  /**
   * @return \Twig_Environment
   */
  public function getTwig();

  /**
   * @return string
   */
  public function renderPattern(PatternInterface $pattern);
}