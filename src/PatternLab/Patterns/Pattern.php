<?php

namespace Labcoat\PatternLab\Patterns;

use Labcoat\PatternLab\PatternLab;

class Pattern implements PatternInterface {

  /**
   * @var string
   */
  protected $description = '';

  /**
   * @var string
   */
  protected $example = '';

  /**
   * @var PatternInterface[]
   */
  protected $includedPatterns = [];

  /**
   * @var PatternInterface[]
   */
  protected $includingPatterns = [];

  /**
   * @var string
   */
  protected $label;

  /**
   * @var string
   */
  protected $name;

  /**
   * @var string
   */
  protected $state = '';

  /**
   * @var string
   */
  protected $subtype;

  /**
   * @var string
   */
  protected $templateContent;

  /**
   * @var string
   */
  protected $type;

  /**
   * @param string $name
   * @param string $type
   * @param string|null $subtype
   */
  public function __construct($name, $type, $subtype = null) {
    $this->name = $name;
    $this->type = $type;
    $this->subtype = $subtype;
  }

  /**
   * @return string
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * @return string
   */
  public function getExample() {
    return $this->example;
  }

  /**
   * @return PatternInterface[]
   */
  public function getIncludedPatterns() {
    return $this->includedPatterns;
  }

  /**
   * @return PatternInterface[]
   */
  public function getIncludingPatterns() {
    return $this->includingPatterns;
  }

  /**
   * @return string
   */
  public function getLabel() {
    return $this->label ?: PatternLab::makeLabel($this->getName());
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getPartial() {
    return PatternLab::makePartial($this->getType(), $this->getName());
  }

  /**
   * @return string
   */
  public function getState() {
    return $this->state;
  }

  /**
   * @return string
   */
  public function getSubtype() {
    return $this->subtype;
  }

  /**
   * @return string
   */
  public function getTemplateContent() {
    return $this->templateContent;
  }

  /**
   * @return string
   */
  public function getType() {
    return $this->type;
  }

  /**
   * @return bool
   */
  public function hasState() {
    return !empty($this->state);
  }

  /**
   * @return bool
   */
  public function hasSubtype() {
    return !empty($this->subtype);
  }

  /**
   * @param string $description
   */
  public function setDescription($description) {
    $this->description = $description;
  }

  /**
   * @param string $example
   */
  public function setExample($example) {
    $this->example = $example;
  }

  /**
   * @param string $label
   */
  public function setLabel($label) {
    $this->label = $label;
  }

  /**
   * @param string $name
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * @param string $state
   */
  public function setState($state) {
    $this->state = $state;
  }

  /**
   * @return string
   */
  public function getStyleguideDirectoryName() {
    $parts = [$this->getType()];
    if ($this->hasSubtype()) $parts[] = $this->getSubtype();
    $parts[] = $this->getName();
    return implode('-', $parts);
  }

  /**
   * @param string $subtype
   */
  public function setSubtype($subtype) {
    $this->subtype = $subtype;
  }

  /**
   * @param string $content
   */
  public function setTemplateContent($content) {
    $this->templateContent = $content;
  }

  /**
   * @param string $type
   */
  public function setType($type) {
    $this->type = $type;
  }
}