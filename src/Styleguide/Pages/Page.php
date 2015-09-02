<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\StyleguideInterface;

abstract class Page implements PageInterface {

  protected $cacheBuster;

  public function __construct(StyleguideInterface $styleguide) {
    $this->cacheBuster = $styleguide->getCacheBuster();
  }

  public function __toString() {
    return $this->getHeader() . $this->getContent() . $this->getFooter();
  }

  public function render(StyleguideInterface $styleguide) {
    // TODO: Implement render() method.
  }

  protected function getCacheBuster() {
    return $this->cacheBuster;
  }

  abstract public function getContent();

  protected function getFooter() {
    return $this->getTwig()->render('patternLabFoot', $this->getFooterVariables());
  }

  protected function getFooterVariables() {
    return [
      'cacheBuster' => $this->getCacheBuster(),
      'patternLabFoot' => $this->getPatternLabFooterContent(),
    ];
  }

  protected function getHeader() {
    return $this->getTwig()->render('patternLabHead', $this->getHeaderVariables());
  }

  protected function getHeaderVariables() {
    $data = [
      'cacheBuster' => $this->getCacheBuster(),
      'patternLabHead' => $this->getPatternLabHeaderContent(),
    ];
    return $data;
  }

  abstract protected function getPatternData();

  protected function getPatternLabFooterContent() {
    $data = [
      'cacheBuster' => $this->getCacheBuster(),
      'patternData' => json_encode($this->getPatternData()),
    ];
    return $this->getTwig()->render('partials/general-footer', $data);
  }

  protected function getPatternLabHeaderContent() {
    $data = [
      'cacheBuster' => $this->getCacheBuster(),
    ];
    return $this->getTwig()->render('partials/general-header', $data);
  }
}