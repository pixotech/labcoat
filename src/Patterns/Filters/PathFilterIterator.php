<?php

namespace Labcoat\Patterns\Filters;

class PathFilterIterator extends \FilterIterator {

  protected $path;

  public function __construct(\Iterator $iterator, $path) {
    parent::__construct($iterator);
    $this->path = $path;
  }

  public function accept() {
    /** @var \Labcoat\Patterns\PatternInterface $pattern */
    $pattern = $this->getInnerIterator()->current();
    return $pattern->getPath() == $this->path;
  }
}