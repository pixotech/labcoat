<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\PatternLab\Styleguide\StyleguideInterface;
use Labcoat\PatternLab\Styleguide\Types\SubtypeInterface;

class ViewAllSubtypePage extends ViewAllTypePage implements ViewAllSubtypePageInterface {

  public function __construct(StyleguideInterface $styleguide, SubtypeInterface $subtype) {
    parent::__construct($styleguide, $subtype);
  }
}
