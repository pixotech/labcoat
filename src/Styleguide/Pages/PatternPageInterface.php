<?php

namespace Labcoat\Styleguide\Pages;

interface PatternPageInterface {

  /**
   * @return \Labcoat\Styleguide\Patterns\PatternInterface
   */
  public function getPattern();
}