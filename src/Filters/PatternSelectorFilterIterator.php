<?php

namespace Labcoat\Filters;

class PatternSelectorFilterIterator extends ItemFilterIterator {

  protected $selector;

  public function __construct(\Iterator $iterator, $selector) {
    parent::__construct($iterator);
    $this->selector = $selector;
  }

  public function accept() {
    if (!$this->hasCurrentItem() || !$this->getCurrentItem()->actsLikePattern()) return false;
    /** @var \Labcoat\Patterns\PatternInterface $pattern */
    $pattern = $this->getCurrentItem();
    if ($pattern->getPartial() == $this->selector) return true;
    if ($pattern->getNormalizedPath() == $this->selector) return true;
    return false;
  }
}