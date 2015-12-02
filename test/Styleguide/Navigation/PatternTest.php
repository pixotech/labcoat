<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Mocks\Patterns\Pattern as Source;
use Labcoat\Patterns\Paths\Name;
use Labcoat\Patterns\Paths\Path;
use Labcoat\Styleguide\Navigation\Items\PatternItem;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $source = $this->makePattern("one-two");
    $pattern = new PatternItem($source);
    $this->assertEquals('One Two', $pattern->getName());
  }

  public function testPartial() {
    $source = $this->makePattern();
    $source->partial = "one-two";
    $pattern = new PatternItem($source);
    $this->assertEquals('one-two', $pattern->getPartial());
  }

  public function testPath() {
    $source = $this->makePattern("one/two/three");
    $pattern = new PatternItem($source);
    $this->assertEquals("one-two-three/one-two-three.html", $pattern->getPath());
  }

  public function testState() {
    $source = $this->makePattern();
    $source->state = "completed";
    $pattern = new PatternItem($source);
    $this->assertEquals($source->state, $pattern->getState());
  }

  protected function makePattern($path = null) {
    $pattern = new Source();
    if (isset($path)) $pattern->path = new Path($path);
    return $pattern;
  }
}