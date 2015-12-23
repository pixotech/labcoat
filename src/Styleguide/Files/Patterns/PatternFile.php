<?php

namespace Labcoat\Styleguide\Files\Patterns;

use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\Styleguide\Files\File;

abstract class PatternFile extends File implements PatternFileInterface {

  protected $pattern;

  public function __construct(PatternInterface $pattern) {
    $this->pattern = $pattern;
  }

  public function getTime() {
    return $this->pattern->getTime();
  }
}