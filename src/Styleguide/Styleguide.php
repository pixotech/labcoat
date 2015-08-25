<?php

namespace Labcoat\Styleguide;

use Labcoat\PatternLabInterface;

class Styleguide {

  protected $patternlab;

  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
  }

  public function generate($destination) {
    #$data = new Data($this->patternlab);
    $this->createPatterns();
  }

  protected function createPatterns() {
    $patterns = $this->patternlab->getPatterns();
    $iterator = new \RecursiveIteratorIterator($patterns, \RecursiveIteratorIterator::CHILD_FIRST);
    print_r(iterator_to_array($iterator, false));
  }
}