<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\Patterns\PatternInterface;

interface IndexPageInterface extends PageInterface {
  public function addPattern(PatternInterface $pattern);
}