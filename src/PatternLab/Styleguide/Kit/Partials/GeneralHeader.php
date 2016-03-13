<?php

namespace Labcoat\PatternLab\Styleguide\Kit\Partials;

use Labcoat\Html\Element;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

class GeneralHeader {

  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide) {
    $this->styleguide = $styleguide;
  }

  public function __toString() {
    $header  = $this->makeMetaHttpEquiv('cache-control', 'max-age=0');
    $header .= $this->makeMetaHttpEquiv('cache-control', 'no-cache');
    $header .= $this->makeMetaHttpEquiv('expires', '0');
    $header .= $this->makeMetaHttpEquiv('expires', 'Tue, 01 Jan 1980 1:00:00 GMT');
    $header .= $this->makeMetaHttpEquiv('pragma', 'no-cache');
    $header .= $this->makeStylesheetLink('../../styleguide/css/styleguide.css', 'all');
    $header .= $this->makeStylesheetLink('../../styleguide/css/styleguide-specific.css');
    return $header;
  }

  public function getCacheBuster() {
    return $this->styleguide->getCacheBuster();
  }

  protected function makeMetaHttpEquiv($header, $content) {
    return new Element('meta', ['http-equiv' => $header, 'content' => $content]);
  }

  protected function makeStylesheetLink($url, $media = null) {
    $url .= '?' . $this->getCacheBuster();
    $attributes = ['rel' => 'stylesheet', 'href' => $url];
    if (isset($media)) $attributes['media'] = $media;
    return new Element('a', $attributes);
  }
}