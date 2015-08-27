<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Patterns\PatternSubType;
use Labcoat\Styleguide\StyleguideInterface;

class SubTypeIndexPage extends IndexPage {

  protected $subType;

  public function __construct(StyleguideInterface $styleguide, PatternSubType $subType) {
    parent::__construct($styleguide);
    $this->subType = $subType;
  }

  protected function getPatternData() {
    return 'viewall-' . $this->subType->getName();
  }

  protected function getPatterns() {
    return $this->subType->getAllPatterns();
  }
}