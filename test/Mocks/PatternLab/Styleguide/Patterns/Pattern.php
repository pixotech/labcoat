<?php

namespace Labcoat\Mocks\PatternLab\Styleguide\Patterns;

use Labcoat\Data\DataInterface;
use Labcoat\PatternLab;
use Labcoat\PatternLab\Styleguide\Patterns\ConfigurationInterface;
use Labcoat\PatternLab\Styleguide\Patterns\PatternInterface;

class Pattern implements PatternInterface {

  public $data;
  public $description;
  public $example;
  public $file;
  public $id;
  public $includedPatterns = [];
  public $includingPatterns = [];
  public $label;
  public $name;
  public $partial;
  public $path;
  public $state;
  public $template;
  public $time;

  public function getExample() {
    return $this->example;
  }

  public function getLabel() {
    return $this->label;
  }

  public function getFile() {
    return $this->file;
  }

  public function getId() {
    return $this->id;
  }

  public function getIncludedPatterns() {
    return $this->includedPatterns;
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

  public function getPseudoPatterns() {
    // TODO: Implement getPseudoPatterns() method.
  }

  public function getState() {
    return $this->state;
  }

  public function getTemplate() {
    return $this->template;
  }

  public function getTime() {
    return $this->time;
  }

  public function getConfiguration() {
    // TODO: Implement getConfiguration() method.
  }

  public function setConfiguration(ConfigurationInterface $configurationInterface) {
    // TODO: Implement setConfiguration() method.
  }

  public function getType() {
    // TODO: Implement getType() method.
  }

  public function hasType() {
    // TODO: Implement hasType() method.
  }

  public function getSubtype() {
    // TODO: Implement getSubtype() method.
  }

  public function hasSubtype() {
    // TODO: Implement hasSubtype() method.
  }

  public function render(DataInterface $data = NULL) {
    // TODO: Implement render() method.
  }

  public function includes(PatternInterface $pattern) {
    // TODO: Implement includes() method.
  }

  public function getNormalizedPath() {
    // TODO: Implement getNormalizedPath() method.
  }

  public function getTemplateNames() {
    // TODO: Implement getTemplateNames() method.
  }

  public function hasTemplateName($name) {
    // TODO: Implement isTemplate() method.
  }

  public function getData() {
    return $this->data;
  }

  public function hasState() {
    return !empty($this->state);
  }

  public function getDescription() {
    return $this->description;
  }

  public function getIncludingPatterns() {
    return $this->includingPatterns;
  }

  public function matches($name) {
    // TODO: Implement matches() method.
  }
}