<?php

namespace Labcoat\Styleguide\Pages;

class StyleguideIndexPage extends IndexPage implements StyleguideIndexPageInterface {

  public function getPath() {
    return ['styleguide', 'html', 'styleguide.html'];
  }

  public function getPatternData() {
    return [];
  }
}