<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Patterns\PatternType;
use Labcoat\Styleguide\StyleguideInterface;

class TypeIndexPage extends IndexPage {

  protected $type;

  public function __construct(StyleguideInterface $styleguide, PatternType $type, array $partials) {
    parent::__construct($styleguide, $partials);
    $this->type = $type;
  }

  protected function getPatternData() {
    return ['patternPartial' => 'viewall-' . $this->type->getName()];
  }
}