<?php

namespace Labcoat\Styleguide;

use Labcoat\Patterns\PatternInterface;

interface StyleguideInterface {

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
  public function getPatternExample(PatternInterface $pattern);

  /**
   * @return array
   */
  public function getPatternPaths();

  /**
   * @return array
   */
  public function getPlugins();
}