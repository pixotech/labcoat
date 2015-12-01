<?php

namespace Labcoat\Paths;

interface SegmentInterface {
  public function getName();
  public function getOrdering();
}