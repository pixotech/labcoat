<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Patterns\PatternInterface;
use Labcoat\Styleguide\Patterns\Pattern;
use Labcoat\Styleguide\StyleguideInterface;

abstract class IndexPage extends Page implements IndexPageInterface {

  protected $patterns = [];

  public function __construct(StyleguideInterface $styleguide) {
    parent::__construct($styleguide);
  }

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = new Pattern($pattern);
  }

  public function getContent(StyleguideInterface $styleguide) {
    $patterns = $this->getPatterns();
    foreach ($patterns as $pattern) {
      $pattern->setContent($styleguide->renderPattern($pattern));
    }
    $variables = [
      'partials' => $patterns,
      'patternPartial' => '',
    ];
    return $styleguide->getTwig()->render('viewall', $variables);
  }

  public function getPatterns() {
    return $this->patterns;
  }
}