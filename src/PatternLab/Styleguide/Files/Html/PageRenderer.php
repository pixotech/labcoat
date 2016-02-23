<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html;

use Labcoat\PatternLab\Styleguide\Twig\HeaderFooterTemplateLoader;
use Labcoat\PatternLab\Styleguide\Twig\StyleguideTemplateLoader;

class PageRenderer implements PageRendererInterface {

  /**
   * @var string
   */
  protected $cacheBuster;

  /**
   * @var \Twig_Environment
   */
  protected $headerFooterTemplateParser;

  /**
   * @var \Twig_Environment
   */
  protected $styleguideTemplateParser;


  public function __construct($header, $footer) {
    $this->makeHeaderFooterTemplateParser($header, $footer);
    $this->makeStyleguideTemplateParser();
  }

  /**
   * @return string
   */
  public function getCacheBuster() {
    return $this->cacheBuster;
  }

  public function renderPage($content, array $data = []) {
    return $this->renderHeader() . $content . $this->renderFooter($data);
  }

  public function renderPatterns(array $patterns) {
    $vars = ['partials' => $patterns, 'patternPartial' => ''];
    return $this->styleguideTemplateParser->render('viewall', $vars);
  }

  /**
   * @param string $cacheBuster
   */
  public function setCacheBuster($cacheBuster) {
    $this->cacheBuster = $cacheBuster;
  }

  /**
   * @param array $data
   * @return string
   */
  protected function makeGeneralFooter(array $data) {
    $vars = ['cacheBuster' => $this->getCacheBuster(), 'patternData' => json_encode($data)];
    return $this->styleguideTemplateParser->render('partials/general-footer', $vars);
  }

  /**
   * @return string
   */
  protected function makeGeneralHeader() {
    $vars = ['cacheBuster' => $this->getCacheBuster()];
    return $this->styleguideTemplateParser->render('partials/general-header', $vars);
  }

  /**
   * @param string $header
   * @param string $footer
   */
  protected function makeHeaderFooterTemplateParser($header, $footer) {
    $loader = new HeaderFooterTemplateLoader($header, $footer);
    $this->headerFooterTemplateParser = new \Twig_Environment($loader);
  }

  protected function makeStyleguideTemplateParser() {
    $loader = new StyleguideTemplateLoader();
    $this->styleguideTemplateParser = new \Twig_Environment($loader);
  }

  protected function renderFooter(array $data) {
    $vars = ['cacheBuster' => $this->getCacheBuster(), 'patternLabFoot' => $this->makeGeneralFooter($data)];
    return $this->headerFooterTemplateParser->render('footer', $vars);
  }

  protected function renderHeader() {
    $vars = ['cacheBuster' => $this->getCacheBuster(), 'patternLabHead' => $this->makeGeneralHeader()];
    return $this->headerFooterTemplateParser->render('header', $vars);
  }
}