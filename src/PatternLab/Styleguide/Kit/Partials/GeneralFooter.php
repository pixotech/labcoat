<?php

namespace Labcoat\PatternLab\Styleguide\Kit\Partials;

use Labcoat\Html\Element;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

class GeneralFooter {

  /**
   * @var mixed
   */
  protected $data;

  /**
   * @var StyleguideInterface
   */
  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide, $data) {
    $this->styleguide = $styleguide;
    $this->data = $data;
  }

  public function __toString() {
    $footer  = $this->getPatternDataScript();
    $footer .= $this->getPatternLoaderScript();
    $footer .= $this->getPolyfillInsertScript();
    $footer .= $this->getInsertScript();
    return $footer;
  }

  public function getCacheBuster() {
    return $this->styleguide->getCacheBuster();
  }

  public function getData() {
    return $this->data;
  }

  public function getInsertScript() {
    $id = $this->getInsertScriptId();
    $content = $this->getInsertScriptContent();
    return $this->makeScript($content, $id);
  }

  public function getInsertScriptContent() {
    return <<<SCRIPT

(function() {
  if (self != top) {
    var cb = '{$this->getCacheBuster()}';
    var js = [ { "src": "styleguide/bower_components/jwerty.min.js", "dep": [ { "src": "annotations/annotations.js", "dep": [ "styleguide/js/patternlab-pattern.min.js" ] } ] } ];
    scriptLoader.run(js,cb,'pl-js-insert');
  }
})();

SCRIPT;
  }

  public function getInsertScriptId() {
    return "pl-js-insert-{$this->getCacheBuster()}";
  }

  public function getPatternDataScript() {
    return $this->makeScript($this->getPatternDataScriptContent());
  }

  public function getPatternDataScriptContent() {
    return "var patternData = " . json_encode($this->getData()) . ";";
  }

  public function getPatternLoaderScript() {
    return $this->makeScript($this->getPatternLoaderScriptContent());
  }

  public function getPatternLoaderScriptContent() {
    return <<<SCRIPT

/*!
 * scriptLoader - v0.1
 *
 * Copyright (c) 2014 Dave Olsen, http://dmolsen.com
 * Licensed under the MIT license
 *
 */

var scriptLoader = {

  run: function(js,cb,target) {
    var s  = document.getElementById(target+'-'+cb);
    for (var i = 0; i < js.length; i++) {
      var src = (typeof js[i] != "string") ? js[i].src : js[i];
      var c   = document.createElement('script');
      c.src   = '../../'+src+'?'+cb;
      if (typeof js[i] != "string") {
        if (js[i].dep !== undefined) {
          c.onload = function(dep,cb,target) {
            return function() {
              scriptLoader.run(dep,cb,target);
            }
          }(js[i].dep,cb,target);
        }
      }
      s.parentNode.insertBefore(c,s);
    }
  }

}

SCRIPT;
  }

  public function getPolyfillInsertScript() {
    $id = $this->getPolyfillInsertScriptId();
    $content = $this->getPolyfillInsertScriptContent();
    return $this->makeScript($content, $id);
  }

  public function getPolyfillInsertScriptContent() {
    return <<<SCRIPT

(function() {
  if (self != top) {
    var cb = '{$this->getCacheBuster()}';
    var js = [];
    if (typeof document !== "undefined" && !("classList" in document.documentElement)) {
      js.push("styleguide/bower_components/classList.min.js");
    }
    scriptLoader.run(js,cb,'pl-js-polyfill-insert');
  }
})();

SCRIPT;
  }

  public function getPolyfillInsertScriptId() {
    return "pl-js-polyfill-insert-{$this->getCacheBuster()}";
  }

  protected function makeScript($content, $id = null) {
    $attributes = [];
    if (isset($id)) $attributes['id'] = $id;
    return new Element('script', $attributes, $content);
  }
}