<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\PatternLab;
use Labcoat\Patterns\PatternInterface as SourcePattern;

class Pattern implements \JsonSerializable, PatternInterface {

  protected $name;
  protected $path;
  protected $partial;
  protected $sourcePath;
  protected $state;

  public function __construct(SourcePattern $pattern) {
    $this->name = $this->makeName($pattern);
    $this->path = $this->makePath($pattern);
    $this->partial = $this->makePartial($pattern);
    $this->sourcePath = str_replace('~', '-', $pattern->getPath());
    $this->state = $pattern->getState();
  }

  public function getName() {
    return $this->name;
  }

  public function getPartial() {
    return $this->partial;
  }

  public function getPath() {
    return $this->path;
  }

  public function getSourcePath() {
    return $this->sourcePath;
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

  public function makeName(SourcePattern $pattern) {
    return ucwords(preg_replace('|[-~]|', ' ', $pattern->getName()));
  }

  public function makePartial(SourcePattern $pattern) {
    return $pattern->getPartial();
  }

  public function makePath(SourcePattern $pattern) {
    $path = Navigation::escapePath($pattern->getPath());
    return PatternLab::makePath([$path, "$path.html"]);
  }
}