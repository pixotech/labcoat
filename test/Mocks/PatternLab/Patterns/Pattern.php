<?php

namespace Labcoat\Mocks\PatternLab\Patterns;

use Labcoat\PatternLab\Patterns\PatternInterface;

class Pattern implements PatternInterface {

  /**
   * @var array
   */
  public $data = [];

  /**
   * @var string
   */
  public $description;

  public $example;

  public $includedPatterns = [];

  public $includingPatterns = [];

  /**
   * @var string
   */
  public $file;

  /**
   * @var string
   */
  public $label;

  /**
   * @var string
   */
  public $name;

  /**
   * @var string
   */
  public $partial;

  /**
   * @var string
   */
  public $path;

  /**
   * @var array
   */
  public $pseudopatterns = [];

  /**
   * @var string
   */
  public $state;

  /**
   * @var string
   */
  public $styleguideDirectoryName;

  /**
   * @var string
   */
  public $subtype;

  /**
   * @var string
   */
  public $templateContent;

  /**
   * @var string
   */
  public $type;

  public function getDescription() {
    return $this->description;
  }

  /**
   * @return string
   */
  public function getLabel() {
    return $this->label;
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

  public function getExample() {
    return $this->example;
  }

  public function setDescription($description) {
    // TODO: Implement setDescription() method.
  }

  public function setExample($example) {
    // TODO: Implement setExample() method.
  }

  /**
   * @return array
   */
  public function getIncludedPatterns() {
    return $this->includedPatterns;
  }

  /**
   * @return array
   */
  public function getIncludingPatterns() {
    return $this->includingPatterns;
  }

  public function setLabel($label) {
    // TODO: Implement setLabel() method.
  }

  public function setName($name) {
    // TODO: Implement setName() method.
  }

  public function setState($state) {
    // TODO: Implement setState() method.
  }

  public function getStyleguideDirectoryName() {
    return $this->styleguideDirectoryName;
  }

  public function setSubtype($subtype) {
    // TODO: Implement setSubtype() method.
  }

  public function setType($type) {
    // TODO: Implement setType() method.
  }

  public function getPartial() {
    return $this->partial;
  }

  public function getTemplateContent() {
    return $this->templateContent;
  }

  public function setTemplateContent($content) {
    $this->templateContent = $content;
  }
}