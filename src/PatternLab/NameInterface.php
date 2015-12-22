<?php

namespace Labcoat\PatternLab;

interface NameInterface {

  /**
   * @return string
   */
  public function capitalized();

  /**
   * @return int|null
   */
  public function getOrdering();

  /**
   * @return bool
   */
  public function hasOrdering();

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