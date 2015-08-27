<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Styleguide\Patterns\Pattern;
use Labcoat\Styleguide\StyleguideInterface;

class PatternPage extends Page implements PatternPageInterface {

  protected $pattern;

  public function __construct(StyleguideInterface $styleguide, PatternInterface $pattern) {
    parent::__construct($styleguide);
    $this->pattern = $pattern;
  }

  public function getContent() {
    $path = $this->pattern->getPath();
    $data = [];
    return $this->styleguide->getPatternLab()->render($path, $data);
  }

  protected function getPatternData() {
    $pattern = new Pattern($this->styleguide, $this->pattern);
    return $pattern;
  }
}