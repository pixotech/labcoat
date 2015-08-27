<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Patterns\PatternType;
use Labcoat\Styleguide\StyleguideInterface;

class TypeIndexPage extends IndexPage {

  protected $type;

  public function __construct(StyleguideInterface $styleguide, PatternType $type) {
    parent::__construct($styleguide);
    $this->type = $type;
  }

  protected function getPatternData() {
    return 'viewall-' . $this->type->getName();
  }

  protected function getPatterns() {
    return $this->type->getAllPatterns();
  }
}