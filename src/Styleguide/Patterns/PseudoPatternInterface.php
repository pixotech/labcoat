<?php

namespace Labcoat\Styleguide\Patterns;

interface PseudoPatternInterface extends PatternInterface {
  public function getParentId();
  public function getVariantName();
}