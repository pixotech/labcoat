<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Patterns\PatternType;
use Labcoat\Styleguide\Pages\TypeIndexPage;
use Labcoat\Styleguide\StyleguideInterface;

class TypeIndexFile extends File implements TypeIndexFileInterface {

  /**
   * @var PatternType
   */
  protected $type;

  public function __construct(StyleguideInterface $styleguide, PatternType $type) {
    $this->styleguide = $styleguide;
    $this->type = $type;
  }

  public function getContents() {
    $page = new TypeIndexPage($this->styleguide, $this->type);
    return $page->__toString();
  }

  public function getPath() {
    return $this->makePath(['patterns', $this->type->getName(), 'index.html']);
  }

  public function getTime() {
    return $this->type->getTime();
  }
}