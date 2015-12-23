<?php

namespace Labcoat\Styleguide\Files\Html;

use Labcoat\Styleguide\Files\File;
use Labcoat\Styleguide\StyleguideInterface;

abstract class Page extends File implements PageInterface {

  public function put(StyleguideInterface $styleguide, $path) {
    file_put_contents($path, $this->getDocument($styleguide));
  }

  protected function getDocument(StyleguideInterface $styleguide) {
    $contents  = $this->makeHeader($styleguide);
    $contents .= $this->getDocumentContent($styleguide);
    $contents .= $this->makeFooter($styleguide);
    return $contents;
  }

  abstract protected function getDocumentContent(StyleguideInterface $styleguide);

  protected function getFooterVariables(StyleguideInterface $styleguide) {
    return [
      'cacheBuster' => $styleguide->getCacheBuster(),
      'patternLabFoot' => $this->getPatternLabFooterContent($styleguide),
    ];
  }

  protected function getHeaderVariables(StyleguideInterface $styleguide) {
    return [
      'cacheBuster' => $styleguide->getCacheBuster(),
      'patternLabHead' => $this->getPatternLabHeaderContent($styleguide),
    ];
  }

  protected function getPatternData() {
    return [];
  }

  protected function getPatternLabFooterContent(StyleguideInterface $styleguide) {
    $data = [
      'cacheBuster' => $styleguide->getCacheBuster(),
      'patternData' => json_encode($this->getPatternData()),
    ];
    return $styleguide->render('partials/general-footer', $data);
  }

  protected function getPatternLabHeaderContent(StyleguideInterface $styleguide) {
    $data = [
      'cacheBuster' => $styleguide->getCacheBuster(),
    ];
    return $styleguide->render('partials/general-header', $data);
  }

  protected function makeFooter(StyleguideInterface $styleguide) {
    return $styleguide->render('patternLabFoot', $this->getFooterVariables($styleguide));
  }

  protected function makeHeader(StyleguideInterface $styleguide) {
    return $styleguide->render('patternLabHead', $this->getHeaderVariables($styleguide));
  }
}