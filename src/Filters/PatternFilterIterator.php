<?php

namespace Labcoat\Filters;

class PatternFilterIterator extends ItemFilterIterator {

  public function accept() {
    return $this->hasCurrentItem() && $this->getCurrentItem()->isPattern();
  }
}