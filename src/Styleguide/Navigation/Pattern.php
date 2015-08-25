<?php

namespace Labcoat\Styleguide\Navigation;

class Pattern implements \JsonSerializable {

  protected $pattern;

  public function __construct(\Labcoat\Patterns\Pattern $pattern) {
    $this->pattern = $pattern;
  }

  public function getName() {
    $name = \Labcoat\Patterns\Pattern::stripOrdering($this->pattern->getName());
    return ucwords(str_replace('-', ' ', $name));
  }

  public function getPartial() {
    return $this->pattern->getPartial();
  }

  public function getPatternPath() {
    $path = implode('-', explode('/', $this->getSourcePath()));
    return $path . DIRECTORY_SEPARATOR . $path . ".html";
  }

  public function getState() {
    return '';
  }

  public function getSourcePath() {
    return $this->pattern->getPath();
  }

  public function jsonSerialize() {
    return [
      "patternPath" => $this->getPatternPath(),
      "patternSrcPath" => $this->getSourcePath(),
      "patternName" => $this->getName(),
      "patternState" => $this->getState(),
      "patternPartial" => $this->getPartial(),
    ];
  }
}