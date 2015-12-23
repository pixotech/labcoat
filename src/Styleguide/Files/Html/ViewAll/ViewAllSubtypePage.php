<?php

namespace Labcoat\Styleguide\Files\Html\ViewAll;

use Labcoat\PatternLab\Patterns\Types\SubtypeInterface;

class ViewAllSubtypePage extends ViewAllPage implements ViewAllSubtypePageInterface {

  protected $partial;
  protected $path;

  public function __construct(SubtypeInterface $subtype) {
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
