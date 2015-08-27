<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Patterns\PatternSubType;
use Labcoat\Patterns\PatternType;
use Labcoat\Styleguide\Pages\SubTypeIndexPage;
use Labcoat\Styleguide\StyleguideInterface;

class SubTypeIndexFile extends File implements SubTypeIndexFileInterface {

  /**
   * @var PatternType
   */
  protected $subType;

  public function __construct(StyleguideInterface $styleguide, PatternSubType $subType) {
    $this->styleguide = $styleguide;
    $this->subType = $subType;
  }

  public function getContents() {
    $page = new SubTypeIndexPage($this->styleguide, $this->subType);
    return $page->__toString();
  }

  public function getPath() {
    return $this->makePath(['patterns', $this->subType->getStyleguidePathName(), 'index.html']);
  }

  public function getTime() {
    return $this->subType->getTime();
  }
}