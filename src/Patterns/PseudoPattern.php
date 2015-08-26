<?php

namespace Labcoat\Patterns;

class PseudoPattern implements PseudoPatternInterface {

  protected $data;
  protected $name;
  protected $pattern;

  public function __construct(PatternInterface $pattern, $name, $path) {
    $this->pattern = $pattern;
    $this->name = $name;
    $this->data = new PatternData($path);
  }

  public function getData() {
    return $this->data;
  }

  public function getFile() {
    return $this->pattern->getFile();
  }

  public function getName() {
    return $this->pattern->getName();
  }

  public function getPath() {
    return $this->pattern->getPath();
  }

  public function getSubtype() {
    return $this->pattern->getSubtype();
  }

  public function getStyleguidePathName() {
    return $this->pattern->getStyleguidePathName() . '-' . str_replace('/', '-', $this->getVariantName());
  }

  public function getTime() {
    $patternTime = $this->pattern->getTime();
    $dataTime = filemtime($this->data->getFile());
    return max($patternTime, $dataTime);
  }

  public function getType() {
    return $this->pattern->getType();
  }

  public function hasSubtype() {
    return $this->pattern->hasSubtype();
  }

  public function getPattern() {
    return $this->pattern;
  }

  public function getVariantName() {
    return $this->name;
  }
}