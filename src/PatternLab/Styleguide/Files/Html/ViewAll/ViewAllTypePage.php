<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Paths\Path;
use Labcoat\PatternLab\Styleguide\Files\Html\PageRendererInterface;
use Labcoat\PatternLab\Styleguide\Types\TypeInterface;

class ViewAllTypePage extends ViewAllPage implements ViewAllTypePageInterface {

  protected $type;

  public function __construct(PageRendererInterface $renderer, TypeInterface $type) {
    parent::__construct($renderer);
    $this->type = $type;
  }

  public function getData() {
    return ['patternPartial' => $this->getPartial()];
  }

  public function getPartial() {
    return $this->type->getPartial();
  }

  public function getPath() {
    $id = $this->type->getId();
    return new Path("patterns/$id/index.html");
  }
}