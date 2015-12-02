<?php

namespace Labcoat\Patterns\Paths;

interface NameInterface {

  /**
   * @return string
   */
  public function capitalized();

  /**
   * @return string
   */
  public function lowercase();

  /**
   * @return array
   */
  public function words();
}