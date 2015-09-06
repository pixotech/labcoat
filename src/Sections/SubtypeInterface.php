<?php

namespace Labcoat\Sections;

use Labcoat\Patterns\PatternInterface;

interface SubtypeInterface extends SectionInterface {

  public function addPattern(PatternInterface $pattern);
}