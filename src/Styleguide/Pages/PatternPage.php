<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Styleguide\Patterns\Pattern;
use Labcoat\Styleguide\StyleguideInterface;

class PatternPage extends Page implements PatternPageInterface {

  protected $pattern;

  public function __construct(StyleguideInterface $styleguide, PatternInterface $pattern) {
    parent::__construct($styleguide);
    $this->pattern = new Pattern($pattern);
  }

  public function getContent() {
    return $this->styleguide->getPatternExample($this->pattern);
  }

  public function getPath() {
    return $this->pattern->getFilePath('html');
  }

  public function getPattern() {
    return $this->pattern;
  }

  protected function getFooterVariables() {
    return array_merge(parent::getFooterVariables(), $this->pattern->getData());
  }

  protected function getHeaderVariables() {
    return array_merge(parent::getHeaderVariables(), $this->pattern->getData());
  }

  protected function getPatternData() {
    return $this->pattern;
  }
}