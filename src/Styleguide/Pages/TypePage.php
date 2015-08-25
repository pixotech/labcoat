<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Patterns\Type;
use Labcoat\Styleguide\StyleguideInterface;

class TypePage extends Page {

  protected $type;

  public function __construct(StyleguideInterface $styleguide, Type $type) {
    parent::__construct($styleguide);
    $this->type = $type;
  }

  public function getContent() {
    // TODO: Implement getContent() method.
  }

  public function getPath() {
    return $this->type->getPath();
  }
}