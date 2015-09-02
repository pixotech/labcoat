<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\PatternLab;
use Labcoat\Patterns\PatternTypeInterface;
use Labcoat\Styleguide\StyleguideInterface;

class TypeIndexPage extends IndexPage implements TypeIndexPageInterface {

  protected $typeName;

  public function __construct(StyleguideInterface $styleguide, PatternTypeInterface $type) {
    parent::__construct($styleguide);
    $this->typeName = $type->getName();
  }

  public function getPath() {
    return $this->typeName;
  }

  public function render(StyleguideInterface $styleguide) {
    // TODO: Implement render() method.
  }

  protected function getPatternData() {
    $name = PatternLab::stripDigits($this->typeName);
    return ['patternPartial' => "viewall-{$name}-all"];
  }
}