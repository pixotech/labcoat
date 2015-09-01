<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\PatternLab;
use Labcoat\Patterns\PatternSubType;
use Labcoat\Styleguide\StyleguideInterface;

class SubTypeIndexPage extends IndexPage {

  protected $subType;

  public function __construct(StyleguideInterface $styleguide, PatternSubType $subType, array $partials = []) {
    parent::__construct($styleguide, $partials);
    $this->subType = $subType;
  }

  protected function getPatternData() {
    $typeName = PatternLab::stripDigits($this->subType->getType()->getName());
    $name = PatternLab::stripDigits($this->subType->getName());
    return ['patternData' => "viewall-{$typeName}-{$name}"];
  }

  protected function getPatterns() {
    return $this->subType->getAllPatterns();
  }
}