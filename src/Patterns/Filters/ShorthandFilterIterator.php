<?php

namespace Labcoat\Patterns\Filters;

class ShorthandFilterIterator extends \FilterIterator {

  protected $shorthand;

  public function __construct(\Iterator $iterator, $shorthand) {
    parent::__construct($iterator);
    $this->shorthand = $shorthand;
  }

  public function accept() {
    /** @var \Labcoat\Patterns\PatternInterface $pattern */
    $pattern = $this->getInnerIterator()->current();
    return $pattern->getShorthand() == $this->shorthand;
  }
}