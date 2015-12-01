<?php

namespace Labcoat\Styleguide\Lineage;

use Labcoat\Styleguide\Patterns\PatternInterface;

interface LineageInterface {
  public function addPattern(PatternInterface $pattern);
  public function getPatterns();
}