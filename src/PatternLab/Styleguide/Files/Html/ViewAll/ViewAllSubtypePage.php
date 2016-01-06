<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\PatternLab\Patterns\Types\SubtypeInterface;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

class ViewAllSubtypePage extends ViewAllTypePage implements ViewAllSubtypePageInterface {

  public function __construct(StyleguideInterface $styleguide, SubtypeInterface $subtype) {
    parent::__construct($styleguide, $subtype);
  }
}
