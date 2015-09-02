<?php

namespace Labcoat\Styleguide\Navigation;

class Pattern implements \JsonSerializable, PatternInterface {

  protected $name;
  protected $path;
  protected $partial;
  protected $state;

  public function __construct(\Labcoat\Patterns\PatternInterface $pattern) {
    $this->name = $pattern->getName();
    $this->path = $pattern->getPath();
    $this->partial = $pattern->getPartial();
    $this->state = $pattern->getState();
  }

  public function getName() {
    return ucwords(str_replace('-', ' ', $this->name));
  }

  public function getPartial() {
    return $this->partial;
  }

  public function getPath() {
    $path = str_replace('/', '-', $this->path);
    return $path . DIRECTORY_SEPARATOR . $path . '.html';
  }

  public function getSourcePath() {
    return $this->path;
  }

  public function getState() {
    return $this->state;
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