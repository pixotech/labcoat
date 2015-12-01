<?php

namespace Labcoat\Structure;

use Labcoat\Patterns\PatternInterface;

interface SubtypeInterface extends SectionInterface {

  public function addPattern(PatternInterface $pattern);
}