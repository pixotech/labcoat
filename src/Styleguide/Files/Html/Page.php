<?php

namespace Labcoat\Styleguide\Files\Html;

use Labcoat\Generator\Files\File;
use Labcoat\Styleguide\StyleguideInterface;

abstract class Page extends File implements PageInterface {

  /**
   * @var StyleguideInterface
   */
  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide) {
    $this->styleguide = $styleguide;
  }

  public function put($path) {
    file_put_contents($path, $this->getDocument());
  }

  protected function getCacheBuster() {
    return $this->styleguide->getCacheBuster();
  }

  protected function getDocument() {
    $contents  = $this->makeHeader();
    $contents .= $this->getDocumentContent();
    $contents .= $this->makeFooter();
    return $contents;
  }

  abstract protected function getDocumentContent();

  protected function getFooterVariables() {
    return [
      'cacheBuster' => $this->getCacheBuster(),
      'patternLabFoot' => $this->getPatternLabFooterContent(),
    ];
  }

  protected function getHeaderVariables() {
    return [
      'cacheBuster' => $this->getCacheBuster(),
      'patternLabHead' => $this->getPatternLabHeaderContent(),
    ];
  }

  protected function getPatternData() {
    return [];
  }

  protected function getPatternLabFooterContent() {
    $data = [
      'cacheBuster' => $this->getCacheBuster(),
      'patternData' => json_encode($this->getPatternData()),
    ];
    return $this->render('partials/general-footer', $data);
  }

  protected function getPatternLabHeaderContent() {
    $data = [
      'cacheBuster' => $this->getCacheBuster(),
    ];
    return $this->render('partials/general-header', $data);
  }

  protected function makeFooter() {
    return $this->render('patternLabFoot', $this->getFooterVariables());
  }

  protected function makeHeader() {
    return $this->render('patternLabHead', $this->getHeaderVariables());
  }

  protected function render($template, array $vars = []) {
    return $this->styleguide->render($template, $vars);
  }
}