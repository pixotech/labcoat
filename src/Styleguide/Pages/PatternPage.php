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

  public function getContent(StyleguideInterface $styleguide) {
    return $styleguide->renderPattern($this->pattern);
  }

  public function getPath() {
    return $this->pattern->getFilePath('html');
  }

  public function getPattern() {
    return $this->pattern;
  }

  protected function getFooterVariables(StyleguideInterface $styleguide) {
    $data = $styleguide->getPatternData($this->pattern);
    return array_replace_recursive(parent::getFooterVariables($styleguide), $data);
  }

  protected function getHeaderVariables(StyleguideInterface $styleguide) {
    $data = $styleguide->getPatternData($this->pattern);
    return array_replace_recursive(parent::getHeaderVariables($styleguide), $data);
  }

  protected function getPatternData() {
    return $this->pattern;
  }
}