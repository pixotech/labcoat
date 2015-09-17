<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\Patterns\PatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

abstract class IndexPage extends Page implements IndexPageInterface {

  protected $partial;
  protected $patterns = [];
  protected $time;

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
    $this->time = max($this->time, $pattern->getTime());
  }

  public function getContent(StyleguideInterface $styleguide) {
    $variables = [
      'partials' => $this->getPatterns(),
      'patternPartial' => '',
    ];
    return $styleguide->render('viewall', $variables);
  }

  /**
   * @return \Labcoat\Styleguide\Patterns\PatternInterface[]
   */
  public function getPatterns() {
    return $this->patterns;
  }

  public function getTime() {
    return $this->time;
  }
}