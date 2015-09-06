<?php

namespace Labcoat\Styleguide\Patterns;

use Labcoat\Patterns\PseudoPatternInterface as SourcePatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

class PseudoPattern extends Pattern implements PseudoPatternInterface {

  protected $parentId;
  protected $variant;

  public function __construct(StyleguideInterface $styleguide, SourcePatternInterface $pattern) {
    parent::__construct($styleguide, $pattern);
    $this->parentId = $pattern->getPattern()->getId();
    $this->variant = $pattern->getVariantName();
  }

  public function getParentId() {
    return $this->parentId;
  }

  /**
   * @return string
   */
  public function getVariantName() {
    return $this->variant;
  }

  protected function makeData() {
    $parent = $this->getPatternLab()->getPattern($this->getParentId());
    $source = $parent->getPseudoPatterns()[$this->getVariantName()];
    $data = $this->styleguide->getPattern($this->getParentId())->getData();
    $this->data = array_replace_recursive($data, $source->getData());
  }
}