<?php

namespace Labcoat\PatternLab\Patterns\Filters;

use Labcoat\PatternLab\Patterns\PatternInterface;

class PatternFilterIterator extends \FilterIterator implements PatternFilterIteratorInterface {

  protected $name;

  public function __construct(\Iterator $iterator, $name) {
    parent::__construct($iterator);
    $this->name = $name;
  }

  public function accept() {
    $pattern = $this->current();
    if (!($pattern instanceof PatternInterface)) return false;
    return $pattern->is($this->name);
  }
}
