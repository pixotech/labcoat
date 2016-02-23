<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\PatternLab\Styleguide\Files\Html\PageRendererInterface;
use Labcoat\PatternLab\Styleguide\Types\SubtypeInterface;

class ViewAllSubtypePage extends ViewAllTypePage implements ViewAllSubtypePageInterface {

  public function __construct(PageRendererInterface $renderer, SubtypeInterface $subtype) {
    parent::__construct($renderer, $subtype);
  }
}
