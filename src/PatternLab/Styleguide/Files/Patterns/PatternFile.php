<?php

namespace Labcoat\PatternLab\Styleguide\Files\Patterns;

use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\Generator\Files\File;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

abstract class PatternFile extends File implements PatternFileInterface {

  protected $pattern;

  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide, PatternInterface $pattern) {
    $this->styleguide = $styleguide;
    $this->pattern = $pattern;
  }

  public function getTime() {
    return time();
  }

  protected function getPatternDirectoryName() {
    return $this->styleguide->getPatternDirectoryName($this->pattern);
  }
}