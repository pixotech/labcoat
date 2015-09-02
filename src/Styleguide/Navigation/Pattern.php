<?php

namespace Labcoat\Styleguide\Navigation;

class Pattern implements \JsonSerializable, PatternInterface {

  protected $pattern;

  public function __construct(\Labcoat\Patterns\PatternInterface $pattern) {
    #$this->pattern = $pattern;
  }

  public function getName() {
    return ucwords(str_replace('-', ' ', $this->pattern->getName()));
  }

  public function getPartial() {
    return $this->pattern->getPartial();
  }

  public function getPath() {
    $path = str_replace('/', '-', $this->pattern->getPath());
    return $path . DIRECTORY_SEPARATOR . $path . '.html';
  }

  public function getSourcePath() {
    return $this->pattern->getPath();
  }

  public function getState() {
    return $this->pattern->getState();
  }

  public function jsonSerialize() {
    return [
      'patternPath' => $this->getPath(),
      'patternSrcPath' => $this->getSourcePath(),
      'patternName' => $this->getName(),
      'patternState' => $this->getState(),
      'patternPartial' => $this->getPartial(),
    ];
  }
}