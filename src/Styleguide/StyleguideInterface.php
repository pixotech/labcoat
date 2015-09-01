<?php

namespace Labcoat\Styleguide;

use Labcoat\Patterns\PatternInterface;

interface StyleguideInterface {

  /**
   * @return string
   */
  public function getCacheBuster();

  /**
   * @return string
   */
  public function getPatternExample(PatternInterface $pattern);

  /**
   * @return \Labcoat\PatternLabInterface
   */
  public function getPatternLab();
}