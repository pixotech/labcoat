<?php

namespace Labcoat\Html;

class Document implements DocumentInterface {

  protected $baseHref;
  protected $body;
  protected $charset = 'UTF-8';
  protected $meta = [];
  protected $scripts = [];
  protected $scriptBlocks = [];
  protected $styleBlocks = [];
  protected $stylesheets = [];
  protected $themeColor;
  protected $title;

  public function __construct($body = null, $title = null) {
    $this->body = $body;
    $this->title = $title;
  }

  public function __toString() {
    return $this->makeDoctype() . $this->makeDocument();
  }

  public function addMeta($name, $content) {
    $this->meta[] = [$name, $content];
  }

  public function includeScript($url) {
    $this->scripts[] = $url;
  }

  public function addScript($script) {
    $this->scriptBlocks[] = $script;
  }

  public function addStyles($styles) {
    $this->styleBlocks[] = $styles;
  }

  public function includeStylesheet($url) {
    $this->stylesheets[] = $url;
  }

  public function getBody() {
    return $this->body;
  }

  public function getThemeColor() {
    return $this->themeColor;
  }

  public function getTitle() {
    return $this->title;
  }

  public function setBaseHref($href) {
    $this->baseHref = $href;
  }

  public function setBody($body) {
    $this->body = $body;
  }

  public function setThemeColor($themeColor) {
    $this->themeColor = $themeColor;
  }

  public function setTitle($title) {
    $this->title = $title;
  }

  protected function hasScripts() {
    return !empty($this->scripts);
  }

  protected function hasStyles() {
    return !empty($this->styles);
  }

  protected function hasStylesheets() {
    return !empty($this->stylesheets);
  }

  protected function makeBody() {
    $body  = $this->getBody();
    if ($this->hasStyles() && $this->hasStylesheets()) $body .= $this->makeStylesheetLinks();
    if ($this->hasScripts()) $body .= $this->makeScriptIncludes();
    foreach ($this->scriptBlocks as $script) {
      $body .= $this->makeElement('script', $script);
    }
    return $this->makeElement('body', $body);
  }

  protected function makeCharsetMeta() {
    return $this->makeElement('meta', ['charset' => $this->charset]);
  }

  protected function makeDoctype() {
    return '<!DOCTYPE html>';
  }

  protected function makeDocument() {
    return $this->makeElement('html', ['lang' => 'en'], $this->makeHead() . $this->makeBody());
  }

  protected function makeHead() {
    return $this->makeElement('head', $this->makeHeadContent());
  }

  protected function makeHeadContent() {
    $head  = $this->makeTitle();
    $head .= $this->makeCharsetMeta();
    $head .= $this->makeMeta('viewport', 'width=device-width');
    if (!empty($this->baseHref)) {
      $head .= $this->makeElement('base', ['href' => $this->baseHref], '');
    }
    if (!empty($this->themeColor)) {
      $head .= $this->makeMeta('theme-color', $this->themeColor);
    }
    foreach ($this->meta as $meta) {
      list($name, $content) = $meta;
      $head .= $this->makeMeta($name, $content);
    }
    if ($this->hasStyles()) $head .= $this->makeStyleBlocks();
    if (!$this->hasStyles() && $this->hasStylesheets()) $head .= $this->makeStylesheetLinks();
    return $head;
  }

  protected function makeElement($name, array $attributes = [], $content = null) {
    return (string) new Element($name, $attributes, $content);
  }

  protected function makeLink(array $attributes) {
    return $this->makeElement('link', $attributes);
  }

  protected function makeMeta($name, $content) {
    return $this->makeElement('meta', ['name' => $name, 'content' => $content]);
  }

  protected function makeStyleBlocks() {
    foreach ($this->styleBlocks as $styles) {
      $blocks[] = $this->makeElement('style', $styles);
    }
    return !empty($blocks) ? implode($blocks) : '';
  }

  protected function makeStylesheetLink($url, $media = 'all') {
    return $this->makeLink(['rel' => 'stylesheet', 'href' => $url, 'media' => $media]);
  }

  protected function makeStylesheetLinks() {
    foreach ($this->stylesheets as $stylesheet) {
      $links[] = $this->makeStylesheetLink($stylesheet);
    }
    return !empty($links) ? implode($links) : '';
  }

  protected function makeScriptInclude($url) {
    return $this->makeElement('script', ['src' => $url]);
  }

  protected function makeScriptIncludes() {
    foreach ($this->scripts as $script) {
      $includes[] = $this->makeScriptInclude($script);
    }
    return !empty($includes) ? implode($includes) : '';
  }

  protected function makeTitle() {
    return $this->makeElement('title', $this->getTitle());
  }
}