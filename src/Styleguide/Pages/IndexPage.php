<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\StyleguideInterface;

abstract class IndexPage extends Page implements IndexPageInterface {

  protected $partials;

  public function __construct(StyleguideInterface $styleguide, array $partials) {
    parent::__construct($styleguide);
    $this->partials = $partials;
  }

  public function getContent() {
    $variables = [
      'partials' => $this->getPartials(),
      'patternPartial' => '',
    ];
    return $this->getTwig()->render('viewall', $variables);
  }

  protected function getPartials() {
    return $this->partials;
  }
}