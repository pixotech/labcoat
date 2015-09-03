<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\PatternLab;
use Labcoat\Patterns\PatternSubTypeInterface;
use Labcoat\Styleguide\StyleguideInterface;

class SubTypeIndexPage extends IndexPage implements SubTypeIndexPageInterface {

  protected $subtypeName;
  protected $typeName;

  public function __construct(StyleguideInterface $styleguide, PatternSubTypeInterface $subType) {
    parent::__construct($styleguide);
    $this->subtypeName = $subType->getName();
    $this->typeName = $subType->getType()->getName();
  }

  public function getPath() {
    return ['patterns', "{$this->typeName}-{$this->subtypeName}", "index.html"];
  }

  protected function getPatternData() {
    $typeName = PatternLab::stripDigits($this->typeName);
    $name = PatternLab::stripDigits($this->subtypeName);
    return ['patternPartial' => "viewall-{$typeName}-{$name}"];
  }
}