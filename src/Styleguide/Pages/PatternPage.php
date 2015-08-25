<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

class PatternPage extends Page {

  protected $pattern;

  public function __construct(StyleguideInterface $styleguide, PatternInterface $pattern) {
    parent::__construct($styleguide);
    $this->pattern = $pattern;
  }

  public function getContent() {
    return $this->getExampleContent();
  }

  public function getExampleContent() {
    return $this->getPatternLab()->render($this->getPatternPath(), $this->getExampleData());
  }

  public function getExampleData() {
    return $this->styleguide->getGlobalData();
  }

  public function getPath() {
    return str_replace('/', '-', $this->pattern->getPath());
  }

  protected function getPatternPath() {
    return $this->pattern->getPath();
  }
}