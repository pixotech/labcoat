<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

use Labcoat\PatternLab\PatternLab;
use Labcoat\PatternLab\Patterns\PatternInterface as SourceInterface;

class Pattern extends AbstractPattern {

  protected $includedPatterns = [];

  protected $source;

  protected $time;

  protected $valid;

  public function __construct(SourceInterface $source, PatternRendererInterface $renderer) {
    parent::__construct($renderer);
    $this->source = $source;
  }

  public function getData() {
    return $this->source->getData();
  }

  public function getDescription() {
    return $this->source->getDescription();
  }

  public function getFile() {
    return $this->source->getFile();
  }

  public function getIncludedPatterns() {
    return [];
  }

  public function getIncludingPatterns() {
    return [];
  }

  public function getLabel() {
    return $this->source->getLabel();
  }

  /**
   * @return string
   */
  public function getName() {
    return PatternLab::stripOrdering($this->source->getName());
  }

  public function getPath() {
    return $this->source->getPath();
  }

  public function getState() {
    return $this->source->getState();
  }

  public function getSubtype() {
    return $this->source->getSubtype();
  }

  public function getTemplate() {
    return $this->source->getPath();
  }

  public function getTime() {
    return filemtime($this->getFile());
  }

  public function getType() {
    return $this->source->getType();
  }

  public function hasState() {
    return false;
  }

  public function hasSubtype() {
    return $this->source->hasSubtype();
  }
}