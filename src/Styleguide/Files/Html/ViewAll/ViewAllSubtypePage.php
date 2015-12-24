<?php

namespace Labcoat\Styleguide\Files\Html\ViewAll;

use Labcoat\PatternLab\Patterns\Types\SubtypeInterface;
use Labcoat\Styleguide\StyleguideInterface;

class ViewAllSubtypePage extends ViewAllPage implements ViewAllSubtypePageInterface {

  protected $partial;
  protected $path;

  public function __construct(StyleguideInterface $styleguide, SubtypeInterface $subtype) {
    parent::__construct($styleguide);
    $this->partial = $subtype->getName();
    $this->path = str_replace(DIRECTORY_SEPARATOR, '-', $subtype->getName());
  }

  public function getPath() {
    return ['patterns', $this->path, "index.html"];
  }

  public function getPatternData() {
    return ['patternPartial' => "viewall-{$this->partial}"];
  }
}
