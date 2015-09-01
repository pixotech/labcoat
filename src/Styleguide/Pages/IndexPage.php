<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\Patterns\Pattern;
use Labcoat\Styleguide\StyleguideInterface;

abstract class IndexPage extends Page implements IndexPageInterface {

  protected $partials;

  public function __construct(StyleguideInterface $styleguide, array $partials = []) {
    parent::__construct($styleguide);
    $this->partials = $partials;
  }

  public function addPartial($partial) {
    $this->partials[] = $partial;
  }

  public function getContent() {
    $variables = [
      'partials' => $this->getPartials(),
      'patternPartial' => '',
    ];
    return $this->getTwig()->render('viewall', $variables);
  }

  protected function getPartials() {
    $partials = [];
    foreach ($this->partials as $partial) {
      $partials[] = new Pattern($this->styleguide, $partial);
    }
    return $partials;
  }
}