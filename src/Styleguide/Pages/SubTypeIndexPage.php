<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\PatternLab\Patterns\Types\SubtypeInterface;

class SubTypeIndexPage extends IndexPage implements SubTypeIndexPageInterface {

  protected $partial;
  protected $path;

  public function __construct(SubtypeInterface $subtype) {
    $this->partial = $subtype->getName();
    $this->path = str_replace(DIRECTORY_SEPARATOR, '-', $subtype->getName());
  }

  public function getPath() {
    return ['patterns', $this->path, "index.html"];
  }

  public function getPatternData() {
    return ['patternPartial' => "viewall-{$this->partial}"];
  }
}
