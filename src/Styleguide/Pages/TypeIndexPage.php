<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Sections\TypeInterface;

class TypeIndexPage extends IndexPage implements TypeIndexPageInterface {

  public function __construct(TypeInterface $type) {
    $this->partial = $type->getSlug() . '-all';
    $this->path = $type->getPath();
  }

  public function getPath() {
    return ['patterns', $this->path, 'index.html'];
  }

  public function getPatternData() {
    return ['patternPartial' => "viewall-{$this->partial}"];
  }
}