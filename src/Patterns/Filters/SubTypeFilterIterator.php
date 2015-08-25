<?php

namespace Labcoat\Patterns\Filters;

use Labcoat\Patterns\SubType;

class SubTypeFilterIterator extends \FilterIterator {

  protected $path;

  public function __construct(\Iterator $iterator) {
    parent::__construct($iterator);
  }

  public function accept() {
    return $this->getInnerIterator()->current() instanceof SubType;
  }
}