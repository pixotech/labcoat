<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html;

use Labcoat\Generator\Files\File;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

abstract class Page extends File implements PageInterface {

  /**
   * @var StyleguideInterface
   */
  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide) {
    $this->styleguide = $styleguide;
  }

  public function getData() {
    return [];
  }

  public function getVariables() {
    return [];
  }

  public function put($path) {
    file_put_contents($path, $this->styleguide->renderPage($this));
  }
}