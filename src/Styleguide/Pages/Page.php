<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\StyleguideInterface;

abstract class Page implements PageInterface {

  protected $cacheBuster;

  public function __construct(StyleguideInterface $styleguide) {
    $this->cacheBuster = $styleguide->getCacheBuster();
  }

  public function render(StyleguideInterface $styleguide) {
    return $this->getHeader($styleguide) . $this->getContent($styleguide) . $this->getFooter($styleguide);
  }

  protected function getCacheBuster() {
    return $this->cacheBuster;
  }

  abstract public function getContent(StyleguideInterface $styleguide);

  protected function getFooter(StyleguideInterface $styleguide) {
    return $styleguide->getTwig()->render('patternLabFoot', $this->getFooterVariables($styleguide));
  }

  protected function getFooterVariables(StyleguideInterface $styleguide) {
    return [
      'cacheBuster' => $this->getCacheBuster(),
      'patternLabFoot' => $this->getPatternLabFooterContent($styleguide),
    ];
  }

  protected function getHeader(StyleguideInterface $styleguide) {
    return $styleguide->getTwig()->render('patternLabHead', $this->getHeaderVariables($styleguide));
  }

  protected function getHeaderVariables(StyleguideInterface $styleguide) {
    $data = [
      'cacheBuster' => $this->getCacheBuster(),
      'patternLabHead' => $this->getPatternLabHeaderContent($styleguide),
    ];
    return $data;
  }

  abstract protected function getPatternData();

  protected function getPatternLabFooterContent(StyleguideInterface $styleguide) {
    $data = [
      'cacheBuster' => $styleguide->getCacheBuster(),
      'patternData' => json_encode($this->getPatternData()),
    ];
    return $styleguide->getTwig()->render('partials/general-footer', $data);
  }

  protected function getPatternLabHeaderContent(StyleguideInterface $styleguide) {
    $data = [
      'cacheBuster' => $this->getCacheBuster(),
    ];
    return $styleguide->getTwig()->render('partials/general-header', $data);
  }
}