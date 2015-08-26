<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

abstract class PatternFile extends File implements PatternFileInterface {

  protected $pattern;
  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide, PatternInterface $pattern) {
    $this->styleguide = $styleguide;
    $this->pattern = $pattern;
  }

  public function getTime() {
    return $this->pattern->getTime();
  }

  protected function getPatternData() {
    return $this->pattern->getData();
  }

  protected function getPatternLab() {
    return $this->styleguide->getPatternLab();
  }

  protected function getPatternPath() {
    return $this->pattern->getPath();
  }

  protected function render() {
    return $this->getPatternLab()->render($this->getPatternPath(), $this->getPatternData());
  }
}