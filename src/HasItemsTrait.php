<?php

/**
 * @package Labcoat
 * @author Pixo <info@pixotech.com>
 * @copyright 2015, Pixo
 * @license http://opensource.org/licenses/NCSA NCSA
 */

namespace Labcoat;

use Labcoat\Patterns\Paths\Path;
use Labcoat\Patterns\Paths\Segment;

trait HasItemsTrait {

  /**
   * Child items of this object
   *
   * @var ItemInterface[]
   */
  protected $items = [];

  /**
   * Current index of the item iterator
   * @var int
   */
  protected $iteratorPosition = 0;

  /**
   * Get the number of items in this object
   *
   * @return int
   */
  public function count() {
    return count($this->items);
  }

  /**
   * Get the current iterator object
   *
   * @return ItemInterface
   * @see http://php.net/manual/en/iterator.current.php Iterator::current
   */
  public function current() {
    return $this->items[$this->getIteratorKey()];
  }

  /**
   * Get an iterator for the current iterator's child items
   *
   * @return ItemInterface
   * @see http://php.net/manual/en/recursiveiterator.getchildren.php RecursiveIterator::getChildren
   */
  public function getChildren() {
    return $this->current();
  }

  /**
   * Does the current iterator item have child items?
   *
   * @return bool
   * @see http://php.net/manual/en/recursiveiterator.haschildren.php RecursiveIterator::hasChildren
   */
  public function hasChildren() {
    return ($this->current() instanceof HasItemsInterface) ? ($this->current()->count() > 0) : false;
  }

  /**
   * Get the current iterator items' key
   *
   * @return string
   * @see http://php.net/manual/en/iterator.key.php Iterator::key
   */
  public function key() {
    return Segment::stripDigits($this->getIteratorKey());
  }

  /**
   * Advance to the next item
   *
   * @see http://php.net/manual/en/iterator.next.php Iterator::next
   */
  public function next() {
    ++$this->iteratorPosition;
  }

  /**
   * Rewind to the first item
   *
   * @see http://php.net/manual/en/iterator.rewind.php Iterator::rewind
   */
  public function rewind() {
    $this->iteratorPosition = 0;
  }

  /**
   * Is there an item at the current position?
   *
   * @return bool
   * @see http://php.net/manual/en/iterator.valid.php Iterator::valid
   */
  public function valid() {
    return $this->iteratorPosition < $this->count();
  }

  /**
   * Get the key of the current item
   *
   * @return string
   */
  protected function getIteratorKey() {
    return array_keys($this->items)[$this->iteratorPosition];
  }
}