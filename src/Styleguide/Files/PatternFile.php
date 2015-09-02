<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Styleguide\Patterns\PatternInterface;

abstract class PatternFile extends File implements PatternFileInterface {

  protected $pattern;

  public function __construct(PatternInterface $pattern) {
    $this->pattern = $pattern;
  }

  public function getTime() {
    return $this->pattern->getTime();
  }
}