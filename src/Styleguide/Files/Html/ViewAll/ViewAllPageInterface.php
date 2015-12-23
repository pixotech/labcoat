<?php

namespace Labcoat\Styleguide\Files\Html\ViewAll;

use Labcoat\Styleguide\Files\Html\PageInterface;
use Labcoat\Styleguide\Patterns\PatternInterface;

interface ViewAllPageInterface extends PageInterface {
  public function addPattern(PatternInterface $pattern);
}