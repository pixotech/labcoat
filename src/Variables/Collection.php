<?php

namespace Labcoat\Variables;

class Collection implements CollectionInterface {

  protected $source = [];

  public function __construct(array $source = []) {
    $this->source = $source;
  }

  public function get($selector) {
    $selection = $this->source;
    foreach ($this->parseSelector($selector) as $var) {
      if ($this->hasVariable($selection, $var)) {
        $selection = $this->getVariable($selection, $var);
      }
      else {
        $selection = null;
        break;
      }
    }
    return $selection;
  }

  protected function getVariable($source, $name) {
    if (is_array($source)) return $source[$name];
    return null;
  }

  protected function hasVariable($source, $name) {
    if (is_array($source)) return array_key_exists($name, $source);
    return false;
  }

  protected function parseSelector($selector) {
    return array_filter(explode('.', $selector));
  }
}