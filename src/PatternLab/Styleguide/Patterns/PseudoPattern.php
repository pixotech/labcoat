<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

use Labcoat\PatternLab\Name;
use Labcoat\PatternLab\PseudoPatternInterface as SourceInterface;

class PseudoPattern extends AbstractPattern {

  protected $source;

  public function __construct(SourceInterface $source, PatternRendererInterface $renderer) {
    parent::__construct($renderer);
    $this->source = $source;
  }

  public function getData() {
    return $this->source->getData() + $this->getPattern()->getData();
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
    return (new Name($this->getName()))->capitalized();
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
    return new Name($this->getPattern()->getSubtype());
  }

  public function getTemplate() {
    return $this->getPattern()->getPath();
  }

  public function getTemplateNames() {
    // TODO: Implement getTemplateNames() method.
  }

  public function getTime() {
    // TODO: Implement getTime() method.
  }

  public function getType() {
    return new Name($this->source->getPattern()->getType());
  }

  public function hasState() {
    return $this->source->getPattern()->getState();
  }

  public function hasSubtype() {
    return $this->source->getPattern()->hasSubtype();
  }

  public function includes(PatternInterface $pattern) {
    // TODO: Implement includes() method.
  }

  public function matches($name) {
    // TODO: Implement matches() method.
  }

  /**
   * @return \Labcoat\PatternLab\PatternInterface
   */
  protected function getPattern() {
    return $this->source->getPattern();
  }
}