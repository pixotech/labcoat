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

  public function put($path) {
    file_put_contents($path, $this->makeDocument());
  }

  protected function getCacheBuster() {
    return $this->styleguide->getCacheBuster();
  }

  protected function getScripts() {
    return $this->styleguide->getScripts();
  }

  protected function getStylesheets() {
    return $this->styleguide->getStylesheets();
  }

  protected function getTitle() {
    return 'Pattern Lab';
  }

  protected function makeDocument() {
    $document = new Document($this->styleguide, $this->getContent(), $this->getData());
    foreach ($this->getStylesheets() as $stylesheet) $document->includeStylesheet($stylesheet);
    foreach ($this->getScripts() as $script) $document->includeScript($script);
    return (string)$document;
  }
}