<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Styleguide\StyleguideInterface;

abstract class Page {

  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide) {
    #$this->styleguide = $styleguide;
  }

  public function __toString() {
    return $this->getHeader() . $this->getContent() . $this->getFooter();
  }

  abstract public function getContent();

  public function getFooter() {
    return $this->getTwig()->render('patternLabFoot', $this->getFooterData());
  }

  public function getHeader() {
    return $this->getTwig()->render('patternLabHead', $this->getHeaderData());
  }

  abstract public function getPath();

  protected function getCacheBuster() {
    return $this->styleguide->getCacheBuster();
  }

  protected function getFooterData() {
    $data = $this->getGlobalData();
    $data += ['cacheBuster' => $this->getCacheBuster()];
    $data['patternLabFoot'] = $this->getTwig()->render('partials/general-footer', $data);
    return $data;
  }

  protected function getGlobalData() {
    return $this->styleguide->getGlobalData();
  }

  protected function getHeaderData() {
    $data = $this->getGlobalData();
    $data += ['cacheBuster' => $this->getCacheBuster()];
    $data['patternLabHead'] = $this->getTwig()->render('partials/general-header', $data);
    return $data;
  }

  protected function getPatternFooter() {
    return $this->styleguide->makePatternFooter();
  }

  protected function getPatternHeader() {
    return $this->styleguide->makePatternHeader();
  }

  protected function getPatternLab() {
    return $this->styleguide->getPatternLab();
  }

  /**
   * @return \Twig_Environment
   */
  protected function getTwig() {
    return $this->styleguide->getTwig();
  }
}