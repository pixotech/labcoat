<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\StyleguideInterface;

abstract class Page implements PageInterface {

  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide) {
    $this->styleguide = $styleguide;
  }

  public function __toString() {
    return $this->getHeader() . $this->getContent() . $this->getFooter();
  }

  protected function getCacheBuster() {
    return $this->styleguide->getCacheBuster();
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
    $data += $this->styleguide->getPatternLab()->getData();
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

  /**
   * @return \Twig_Environment
   */
  protected function getTwig() {
    return $this->styleguide->getTwig();
  }
}