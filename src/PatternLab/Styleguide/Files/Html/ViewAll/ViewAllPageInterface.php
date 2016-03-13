<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\PatternLab\Styleguide\Files\Html\PageInterface;

interface ViewAllPageInterface extends PageInterface {

  public function getPartial();

  public function getPatterns();
}