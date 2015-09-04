<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Styleguide\Patterns\Pattern;
use Labcoat\Styleguide\StyleguideInterface;

class PatternPage extends Page implements PatternPageInterface {

  protected $pattern;

  public function __construct(PatternInterface $pattern) {
    $this->pattern = new Pattern($pattern);
  }

  public function getContent(StyleguideInterface $styleguide) {
    return $styleguide->renderPattern($this->pattern);
  }

  public function getFooterVariables(StyleguideInterface $styleguide) {
    return $styleguide->getPatternData($this->pattern);
  }

  public function getHeaderVariables(StyleguideInterface $styleguide) {
    return $styleguide->getPatternData($this->pattern);
  }

  public function getPath() {
    return $this->pattern->getFilePath('html');
  }

  public function getPattern() {
    return $this->pattern;
  }

  public function getPatternData() {
    return $this->pattern;
  }

  public function getTime() {

  }
}