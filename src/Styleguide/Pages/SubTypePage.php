<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Patterns\PatternSubType;
use Labcoat\Styleguide\StyleguideInterface;

class SubTypePage extends Page {

  protected $subType;

  public function __construct(StyleguideInterface $styleguide, PatternSubType $subType) {
    parent::__construct($styleguide);
    $this->subType = $subType;
  }

  public function getContent() {
    // TODO: Implement getContent() method.
  }

  public function getPath() {
    return $this->subType->getPath();
  }
}