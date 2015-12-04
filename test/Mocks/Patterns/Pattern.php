<?php

namespace Labcoat\Mocks\Patterns;

use Labcoat\Data\DataInterface;
use Labcoat\PatternLab;
use Labcoat\Patterns\Configuration\ConfigurationInterface;
use Labcoat\Patterns\PatternInterface;

class Pattern implements PatternInterface {

  public $file;
  public $id;
  public $label;
  public $name;
  public $normalizedPath;
  public $pagePath;
  public $partial;
  public $path;
  public $slug;
  public $state;
  public $template;

  public function getLabel() {
    return $this->label;
  }

  public function getPagePath() {
    return $this->pagePath;
  }

  public function getFile() {
    return $this->file;
  }

  public function getId() {
    return $this->id;
  }

  public function getIncludedPatterns() {
    // TODO: Implement getIncludedPatterns() method.
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
    // TODO: Implement getTime() method.
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
}