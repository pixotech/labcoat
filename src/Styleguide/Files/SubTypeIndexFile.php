<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Patterns\PatternSubType;
use Labcoat\Patterns\PatternType;

class SubTypeIndexFile extends File implements SubTypeIndexFileInterface {

  /**
   * @var PatternType
   */
  protected $subType;

  public function __construct(PatternSubType $subType) {
    $this->subType = $subType;
  }

  public function getContents() {
    // TODO: Implement getContents() method.
  }

  public function getPath() {
    return $this->makePath(['patterns', $this->subType->getStyleguidePathName(), 'index.html']);
  }

  public function getTime() {
    return $this->subType->getTime();
  }
}