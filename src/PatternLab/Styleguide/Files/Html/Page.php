<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html;

use Labcoat\Generator\Files\File;

abstract class Page extends File implements PageInterface {

  /**
   * @var PageRendererInterface
   */
  protected $renderer;

  public function __construct(PageRendererInterface $renderer) {
    $this->renderer = $renderer;
  }

  public function getData() {
    return [];
  }

  public function put($path) {
    file_put_contents($path, call_user_func($this->renderer, $this->getContent(), $this->getData()));
  }
}