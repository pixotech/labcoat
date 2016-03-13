<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html;

use Labcoat\PatternLab\Styleguide\Kit\Partials\GeneralFooter;
use Labcoat\PatternLab\Styleguide\Kit\Partials\GeneralHeader;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

class Document extends \Labcoat\Html\Document implements DocumentInterface {

  protected $data = [];

  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide, $body, $data = []) {
    parent::__construct($body);
    $this->styleguide = $styleguide;
    $this->data = $data;
  }

  public function getBody() {
    $body = parent::getBody();
    $body .= new GeneralFooter($this->getStyleguide(), $this->getData());
    return $body;
  }

  public function getData() {
    return $this->data;
  }

  public function getStyleguide() {
    return $this->styleguide;
  }

  public function getTitle() {
    return 'Pattern Lab';
  }

  protected function makeHeadContent() {
    $head = parent::makeHeadContent();
    $head .= new GeneralHeader($this->getStyleguide());
    return $head;
  }
}