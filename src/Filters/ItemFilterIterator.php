<?php

namespace Labcoat\Filters;

use FilterIterator;
use Labcoat\ItemInterface;

abstract class ItemFilterIterator extends FilterIterator {

  /**
   * @return \Labcoat\ItemInterface
   */
  protected function getCurrentItem() {
    return $this->getInnerIterator()->current();
  }

  protected function hasCurrentItem() {
    return $this->getInnerIterator()->current() instanceof ItemInterface;
  }
}