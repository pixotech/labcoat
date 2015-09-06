<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Sections\SubtypeInterface;

class SubTypeIndexPage extends IndexPage implements SubTypeIndexPageInterface {

  protected $partial;
  protected $path;

  public function __construct(SubtypeInterface $subType) {
    $this->partial = str_replace('/', '-', $subType->getNormalizedPath());
    $this->path = str_replace('/', '-', $subType->getPath());
  }

  public function getPath() {
    return ['patterns', $this->path, "index.html"];
  }

  public function getPatternData() {
    return ['patternPartial' => "viewall-{$this->partial}"];
  }
}