<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Patterns\PatternType;

class TypeIndexFile extends File implements TypeIndexFileInterface {

  /**
   * @var PatternType
   */
  protected $type;

  public function __construct(PatternType $type) {
    $this->type = $type;
  }

  public function getContents() {
    // TODO: Implement getContents() method.
  }

  public function getPath() {
    return $this->makePath(['patterns', $this->type->getName(), 'index.html']);
  }

  public function getTime() {
    return $this->type->getTime();
  }
}