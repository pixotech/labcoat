<?php

namespace Labcoat\Styleguide\Files\Html\ViewAll;

use Labcoat\PatternLab\Patterns\Types\TypeInterface;
use Labcoat\Styleguide\StyleguideInterface;

class ViewAllTypePage extends ViewAllPage implements ViewAllTypePageInterface {

  public function __construct(StyleguideInterface $styleguide, TypeInterface $type) {
    parent::__construct($styleguide);
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