<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\StyleguideInterface;

class StyleguideIndexPage extends IndexPage {

  public function __construct(StyleguideInterface $styleguide) {
    parent::__construct($styleguide);
  }

  protected function getPatternData() {
    return [];
  }

  protected function getPatterns() {
    return $this->styleguide->getPatternLab()->getPatterns()->getAllPatterns();
  }
}