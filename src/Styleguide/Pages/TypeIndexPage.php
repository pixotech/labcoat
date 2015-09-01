<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\PatternLab;
use Labcoat\Patterns\PatternTypeInterface;
use Labcoat\Styleguide\StyleguideInterface;

class TypeIndexPage extends IndexPage {

  protected $type;

  public function __construct(StyleguideInterface $styleguide, PatternTypeInterface $type, array $partials = []) {
    parent::__construct($styleguide, $partials);
    $this->type = $type;
  }

  protected function getPatternData() {
    $name = PatternLab::stripDigits($this->type->getName());
    return ['patternPartial' => "viewall-{$name}-all"];
  }
}