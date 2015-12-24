<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Paths\Path;
use Labcoat\PatternLab\Patterns\Types\SubtypeInterface;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

class ViewAllSubtypePage extends ViewAllPage implements ViewAllSubtypePageInterface {

  protected $subtype;

  public function __construct(StyleguideInterface $styleguide, SubtypeInterface $subtype) {
    parent::__construct($styleguide);
    $this->subtype = $subtype;
  }

  public function getData() {
    return ['patternPartial' => $this->getPartial()];
  }

  public function getPartial() {
    return 'viewall-' . $this->subtype->getPartial();
  }

  public function getPath() {
    $id = $this->subtype->getId();
    return new Path("patterns/$id/index.html");
  }
}
