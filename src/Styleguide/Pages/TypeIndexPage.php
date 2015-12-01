<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Structure\TypeInterface;

class TypeIndexPage extends IndexPage implements TypeIndexPageInterface {

  public function __construct(TypeInterface $type) {
    $this->partial = $type->getName() . '-all';
    $this->path = $type->getName();
  }

  public function getPath() {
    return ['patterns', $this->path, 'index.html'];
  }

  public function getPatternData() {
    return ['patternPartial' => "viewall-{$this->partial}"];
  }
}