<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

use Labcoat\PatternLab\PatternLab;
use Labcoat\PatternLab\Patterns\PseudoPatternInterface as SourceInterface;

class PseudoPattern extends AbstractPattern {

  protected $source;

  public function __construct(SourceInterface $source, PatternRendererInterface $renderer) {
    parent::__construct($renderer);
    $this->source = $source;
  }

  public function getData() {
    return array_replace_recursive($this->getPattern()->getData(), $this->source->getData());
  }

  public function getDescription() {
    return $this->getPattern()->getDescription();
  }

  public function getFile() {
    return $this->getPattern()->getFile();
  }

  public function getIncludedPatterns() {
    return [];
  }

  public function getIncludingPatterns() {
    return [];
  }

  public function getLabel() {
    return PatternLab::makeLabel($this->getName());
  }

  public function getName() {
    return $this->getPattern()->getName() . '-' . $this->source->getName();
  }

  public function getPath() {
    return $this->getPattern()->getPath() . '-' . $this->source->getName();
  }

  public function getState() {
    return $this->getPattern()->getState();
  }

  public function getSubtype() {
    return $this->getPattern()->getSubtype();
  }

  public function getTime() {
    // TODO: Implement getTime() method.
  }

  public function getType() {
    return $this->getPattern()->getType();
  }

  public function hasState() {
    return $this->getPattern()->getState();
  }

  public function hasSubtype() {
    return $this->getPattern()->hasSubtype();
  }

  /**
   * @return \Labcoat\PatternLab\Patterns\PatternInterface
   */
  protected function getPattern() {
    return $this->source->getPattern();
  }
}