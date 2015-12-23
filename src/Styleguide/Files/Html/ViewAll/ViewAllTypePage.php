<?php

namespace Labcoat\Styleguide\Files\Html\ViewAll;

use Labcoat\PatternLab\Patterns\Types\TypeInterface;

class ViewAllTypePage extends ViewAllPage implements ViewAllTypePageInterface {

  public function __construct(TypeInterface $type) {
    $this->partial = $type->getName() . '-all';
    $this->path = $type->getName();
  }

  public function getPath() {
    return ['patterns', $this->path, 'index.html'];
  }

  public function getPatternData() {
    return ['patternPartial' => "viewall-{$this->partial}"];
  }
}