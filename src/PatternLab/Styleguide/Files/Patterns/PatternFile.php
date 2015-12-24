<?php

namespace Labcoat\PatternLab\Styleguide\Files\Patterns;

use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\Generator\Files\File;

abstract class PatternFile extends File implements PatternFileInterface {

  protected $pattern;

  public function __construct(PatternInterface $pattern) {
    $this->pattern = $pattern;
  }

  public function getTime() {
    return $this->pattern->getTime();
  }
}