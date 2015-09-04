<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\PatternLab;
use Labcoat\Patterns\TypeInterface;

class TypeIndexPage extends IndexPage implements TypeIndexPageInterface {

  protected $typeName;

  public function __construct(TypeInterface $type) {
    $this->typeName = $type->getName();
  }

  public function getPath() {
    return ['patterns', $this->typeName, 'index.html'];
  }

  public function getPatternData() {
    $name = PatternLab::stripDigits($this->typeName);
    return ['patternPartial' => "viewall-{$name}-all"];
  }

  public function getTime() {

  }
}