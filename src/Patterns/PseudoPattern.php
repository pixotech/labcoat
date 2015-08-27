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
    return $this->data->getData() + $this->pattern->getData();
  }

  public function getDisplayName() {
    return $this->pattern->getDisplayName() . ' ' . ucwords(str_replace('-', ' ', $this->getVariantName()));
  }

  public function getFile() {
    return $this->pattern->getFile();
  }

  public function getName() {
    return $this->pattern->getName();
  }

  public function getPartial() {
    return $this->pattern->getPartial();
  }

  public function getPath() {
    return $this->pattern->getPath();
  }

  public function getState() {
    return $this->pattern->getState();
  }

  public function getSubType() {
    return $this->pattern->getSubType();
  }

  public function getStyleguidePathName() {
    return $this->pattern->getStyleguidePathName() . '-' . str_replace('/', '-', $this->getVariantName());
  }

  public function getTemplateContent() {
    return $this->pattern->getTemplateContent();
  }

  public function getTime() {
    $patternTime = $this->pattern->getTime();
    $dataTime = filemtime($this->data->getFile());
    return max($patternTime, $dataTime);
  }

  public function getType() {
    return $this->pattern->getType();
  }

  public function hasSubType() {
    return $this->pattern->hasSubType();
  }

  public function getPattern() {
    return $this->pattern;
  }

  public function getVariantName() {
    return $this->name;
  }
}