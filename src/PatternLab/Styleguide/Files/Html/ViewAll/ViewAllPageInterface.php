<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\PatternLab\Styleguide\Files\Html\PageInterface;
use Labcoat\PatternLab\Patterns\PatternInterface;

interface ViewAllPageInterface extends PageInterface {
  public function addPattern(PatternInterface $pattern);
  public function getContentVariables();
}