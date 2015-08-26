<?php

namespace Labcoat\Styleguide\Pages;

use Labcoat\Patterns\Pattern;
use Labcoat\Patterns\PatternSubType;
use Labcoat\Patterns\PatternType;
use Labcoat\Styleguide\StyleguideInterface;

class PageCollection implements \IteratorAggregate, PageCollectionInterface {

  /**
   * @var Page[]
   */
  protected $pages = [];

  /**
   * @var StyleguideInterface
   */
  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide) {
    $this->styleguide = $styleguide;
    $this->makePages();
    foreach ($this->pages as $page) {
      print $page->getPath() . "\n";
    }
  }

  public function getIterator() {
    return new \ArrayIterator($this->pages);
  }

  protected function makePages() {
    $patterns = $this->styleguide->getPatternLab()->getPatterns();
    $iterator = new \RecursiveIteratorIterator($patterns, \RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($iterator as $item) {
      if ($item instanceof Pattern) {
        $this->pages[] = new PatternPage($this->styleguide, $item);
        foreach (array_keys($item->getPseudoPatterns()) as $pseudoPattern) {
          $this->pages[] = new PseudoPatternPage($this->styleguide, $item, $pseudoPattern);
        }
      }
      elseif ($item instanceof PatternType) {
        $this->pages[] = new TypePage($this->styleguide, $item);
      }
      elseif ($item instanceof PatternSubType) {
        $this->pages[] = new SubTypePage($this->styleguide, $item);
      }
    }
  }
}