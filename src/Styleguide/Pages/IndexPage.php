<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\Patterns\Pattern;

abstract class IndexPage extends Page implements IndexPageInterface {

  public function getContent() {
    $variables = [
      'partials' => $this->getPartials(),
      'patternPartial' => '',
    ];
    return $this->getTwig()->render('viewall', $variables);
  }

  protected function getPartials() {
    $partials = [];
    foreach ($this->getPatterns() as $pattern) {
      $partials[] = new Pattern($this->styleguide, $pattern);
    }
    return $partials;
  }

  abstract protected function getPatterns();
}