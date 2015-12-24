<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Paths\Path;
use Labcoat\PatternLab\Patterns\Types\TypeInterface;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

class ViewAllTypePage extends ViewAllPage implements ViewAllTypePageInterface {

  public function __construct(StyleguideInterface $styleguide, TypeInterface $type) {
    parent::__construct($styleguide);
    $this->partial = $type->getName() . '-all';
    $this->path = $type->getId();
  }

  public function getData() {
    return ['patternPartial' => "viewall-{$this->partial}"];
  }

  public function getPath() {
    return new Path("patterns/{$this->path}/index.html");
  }
}