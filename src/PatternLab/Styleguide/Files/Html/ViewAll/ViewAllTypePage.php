<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Paths\Path;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;
use Labcoat\PatternLab\Styleguide\Types\TypeInterface;

class ViewAllTypePage extends ViewAllPage implements ViewAllTypePageInterface {

  protected $type;

  public function __construct(StyleguideInterface $styleguide, TypeInterface $type) {
    parent::__construct($styleguide);
    $this->type = $type;
  }

  public function getData() {
    return ['patternPartial' => $this->getPartial()];
  }

  public function getPartial() {
    return $this->type->getPartial();
  }

  public function getPath() {
    $dir = $this->type->getStyleguideDirectoryName();
    return new Path("patterns/$dir/index.html");
  }
}