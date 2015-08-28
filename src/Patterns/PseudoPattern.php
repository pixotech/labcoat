<?php

namespace Labcoat\Patterns;

use Labcoat\PatternLab;

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
    return $this->pattern->getName() . '-' . $this->getVariantName();
  }

  public function getPartial() {
    return $this->pattern->getPartial() . '-' . $this->getVariantName();
  }

  public function getPath() {
    return $this->pattern->getPath() . '-' . $this->getVariantName();
  }

  public function getState() {
    return $this->pattern->getState();
  }

  public function getSubType() {
    return $this->pattern->getSubType();
  }

  public function getStyleguidePathName() {
    return $this->pattern->getStyleguidePathName() . '-' . $this->getVariantName();
  }

  public function getTemplate() {
    return $this->pattern->getPath();
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

  public function getLowercaseName() {
    return str_replace('-', ' ', $this->getNameWithoutDigits());
  }

  public function getNameWithoutDigits() {
    return $this->pattern->getNameWithoutDigits() . '-' . $this->getVariantName();
  }

  public function getUppercaseName() {
    return ucwords($this->getLowercaseName());
  }
}