<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\StyleguideInterface;

class StyleguideIndexPage extends IndexPage implements StyleguideIndexPageInterface {

  public function __construct(StyleguideInterface $styleguide) {
    parent::__construct($styleguide);
  }

  public function getPath() {
    return ['styleguide', 'html', 'styleguide.html'];
  }

  protected function getPatternData() {
    return [];
  }
}