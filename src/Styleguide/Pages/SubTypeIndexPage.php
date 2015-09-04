<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\PatternLab;
use Labcoat\Patterns\SubtypeInterface;

class SubTypeIndexPage extends IndexPage implements SubTypeIndexPageInterface {

  protected $subtypeName;
  protected $typeName;

  public function __construct(SubtypeInterface $subType) {
    $this->subtypeName = $subType->getName();
    $this->typeName = $subType->getType()->getName();
  }

  public function getPath() {
    return ['patterns', "{$this->typeName}-{$this->subtypeName}", "index.html"];
  }

  public function getPatternData() {
    $typeName = PatternLab::stripDigits($this->typeName);
    $name = PatternLab::stripDigits($this->subtypeName);
    return ['patternPartial' => "viewall-{$typeName}-{$name}"];
  }

  public function getTime() {
    // TODO: Implement getTime() method.
  }
}