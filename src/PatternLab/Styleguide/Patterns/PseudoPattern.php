<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

use Labcoat\Data\DataInterface;
use Labcoat\PatternLab\Styleguide\Patterns\ConfigurationInterface;

class PseudoPattern implements PseudoPatternInterface {

  protected $pattern;
  protected $time;
  protected $variant;

  public function __construct(PatternInterface $pattern, $variant, $dataFile) {
    $this->pattern = $pattern;
    $this->variant = $variant;
    $this->path = $pattern->getPath() . "~{$variant}";
    $this->id = $this->path;
    $this->name = $pattern->getName() . ' ' . str_replace('-', ' ', $variant);
    $this->dataFiles = [$dataFile];
  }

  public function getConfiguration() {
    return $this->pattern->getConfiguration();
  }

  public function getFile() {
    return $this->pattern->getFile();
  }

  public function getId() {
    return $this->id;
  }

  public function getIncludedPatterns() {
    return $this->pattern->getIncludedPatterns();
  }

  public function getLabel() {

  }

  public function getName() {
    return $this->name;
  }

  public function getPath() {
    return $this->path;
  }

  public function getPartial() {
    return $this->pattern->getPartial() . '-' . $this->getVariantName();
  }

  public function getPattern() {
    return $this->pattern;
  }

  public function getPseudoPatterns() {
    return [];
  }

  public function getState() {
    return $this->pattern->getState();
  }

  public function getTemplate() {
    return $this->pattern->getTemplate();
  }

  public function getTime() {
    if (!isset($this->time)) {
      $this->time = max($this->pattern->getTime(), $this->getDataTime());
    }
    return $this->time;
  }

  public function getVariantName() {
    return $this->variant;
  }

  public function setConfiguration(ConfigurationInterface $configuration) {
    throw new \BadMethodCallException("Pseudo-patterns cannot have configuration");
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
    // TODO: Implement getData() method.
  }

  public function getExample() {
    // TODO: Implement getExample() method.
  }

  public function hasState() {
    // TODO: Implement hasState() method.
  }

  public function getDescription() {
    // TODO: Implement getDescription() method.
  }

  public function getIncludingPatterns() {
    // TODO: Implement getIncludingPatterns() method.
  }

  public function matches($name) {
    // TODO: Implement matches() method.
  }
}