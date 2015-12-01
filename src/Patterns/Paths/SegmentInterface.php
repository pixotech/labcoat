<?php

namespace Labcoat\Patterns\Paths;

interface SegmentInterface {
  public function getName();
  public function getOrdering();

  /**
   * @return bool
   */
  public function hasOrdering();

  public function normalize();
}