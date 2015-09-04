<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\Patterns\PatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

abstract class IndexPage extends Page implements IndexPageInterface {

  protected $patterns = [];

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
  }

  public function getContent(StyleguideInterface $styleguide) {
    $variables = [
      'partials' => $this->getPatterns(),
      'patternPartial' => '',
    ];
    return $styleguide->getTwig()->render('viewall', $variables);
  }

  /**
   * @return \Labcoat\Styleguide\Patterns\PatternInterface[]
   */
  public function getPatterns() {
    return $this->patterns;
  }
}