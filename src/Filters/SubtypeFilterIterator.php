<?php

namespace Labcoat\Filters;

class SubtypeFilterIterator extends ItemFilterIterator {

  public function accept() {
    return $this->hasCurrentItem() && $this->getCurrentItem()->isSubtype();
  }
}