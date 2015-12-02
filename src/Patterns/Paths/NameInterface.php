<?php

namespace Labcoat\Patterns\Paths;

interface NameInterface {

  /**
   * @return string
   */
  public function capitalized();

  /**
   * @param string $delimiter
   * @return string
   */
  public function join($delimiter);

  /**
   * @return string
   */
  public function lowercase();

  /**
   * @return array
   */
  public function words();
}