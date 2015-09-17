<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Styleguide\Pages\PageInterface;
use Labcoat\Styleguide\StyleguideInterface;

class PageFile extends File {

  /**
   * @var PageInterface
   */
  protected $page;

  public function __construct(PageInterface $page) {
    $this->page = $page;
  }

  public function put(StyleguideInterface $styleguide, $path) {
    $contents  = $this->makeHeader($styleguide);
    $contents .= $this->page->getContent($styleguide);
    $contents .= $this->makeFooter($styleguide);
    file_put_contents($path, $contents);
  }

  public function getPath() {
    $path = $this->page->getPath();
    return is_array($path) ? $this->makePath($path) : $path;
  }

  public function getTime() {
    return $this->page->getTime();
  }

  protected function getFooterVariables(StyleguideInterface $styleguide) {
    $vars = $this->page->getFooterVariables($styleguide);
    $vars += [
      'cacheBuster' => $styleguide->getCacheBuster(),
      'patternLabFoot' => $this->getPatternLabFooterContent($styleguide),
    ];
    return $vars;
  }

  protected function getHeaderVariables(StyleguideInterface $styleguide) {
    $vars = $this->page->getHeaderVariables($styleguide);
    $vars += [
      'cacheBuster' => $styleguide->getCacheBuster(),
      'patternLabHead' => $this->getPatternLabHeaderContent($styleguide),
    ];
    return $vars;
  }

  protected function getPatternLabFooterContent(StyleguideInterface $styleguide) {
    $data = [
      'cacheBuster' => $styleguide->getCacheBuster(),
      'patternData' => json_encode($this->page->getPatternData()),
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