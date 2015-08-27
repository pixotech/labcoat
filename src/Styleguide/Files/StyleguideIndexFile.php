<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Styleguide\Pages\StyleguideIndexPage;
use Labcoat\Styleguide\StyleguideInterface;

class StyleguideIndexFile implements StyleguideIndexFileInterface {

  public function __construct(StyleguideInterface $styleguide) {
    $this->styleguide = $styleguide;
  }

  public function getContents() {
    $page = new StyleguideIndexPage($this->styleguide, $this->styleguide->getPatternLab());
    return $page->__toString();
  }

  public function getPath() {
    return implode(DIRECTORY_SEPARATOR, ['styleguide', 'html', 'styleguide.html']);
  }

  public function getTime() {
    return $this->styleguide->getPatternLab()->getPatterns()->getTime();
  }
}