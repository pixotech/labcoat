<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\Patterns\PatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

class PatternPage extends Page implements PatternPageInterface {

  protected $pattern;

  public function __construct(PatternInterface $pattern) {
    $this->pattern = $pattern;
  }

  public function getContent(StyleguideInterface $styleguide) {
    return $this->pattern->getContent();
  }

  public function getFooterVariables(StyleguideInterface $styleguide) {
    return $this->pattern->getData();
  }

  public function getHeaderVariables(StyleguideInterface $styleguide) {
    return $this->pattern->getData();
  }

  public function getPath() {
    return $this->pattern->getPagePath();
  }

  public function getPattern() {
    return $this->pattern;
  }

  public function getPatternData() {
    return $this->pattern;
  }

  public function getTime() {
    return $this->pattern->getTime();
  }
}