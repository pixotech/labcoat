<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Paths\Path;
use Labcoat\PatternLab\Patterns\Types\TypeInterface;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

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
    return 'viewall-' . $this->type->getName() . '-all';
  }

  public function getPath() {
    $id = $this->type->getId();
    return new Path("patterns/$id/index.html");
  }
}