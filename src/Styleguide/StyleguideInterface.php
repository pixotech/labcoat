<?php

namespace Labcoat\Styleguide;

interface StyleguideInterface {

  /**
   * @return array
   */
  public function getGlobalData();

  /**
   * @return \Labcoat\PatternLabInterface
   */
  public function getPatternLab();
}