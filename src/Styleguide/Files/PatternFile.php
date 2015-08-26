<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Patterns\PatternInterface;

abstract class PatternFile implements PatternFileInterface {

  protected $pattern;

  public function __construct(PatternInterface $pattern) {
    $this->pattern = $pattern;
  }

  public function getTime() {
    return filemtime($this->pattern->getFile());
  }
}