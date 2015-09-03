<?php

namespace Labcoat\Patterns\Filters;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PseudoPatternInterface;

class PatternFilterIterator extends \FilterIterator {

  protected $includePsuedo = true;

  public function __construct(\Iterator $iterator, $includePsuedo = true) {
    parent::__construct($iterator);
    $this->includePseudo = $includePsuedo;
  }

  public function accept() {
    $current = $this->getInnerIterator()->current();
    if (!($current instanceof PatternInterface)) return false;
    if (!$this->includePsuedo && ($current instanceof PseudoPatternInterface)) return false;
    return true;
  }
}