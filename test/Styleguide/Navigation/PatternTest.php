<?php

namespace Labcoat\Styleguide\Navigation;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $source = $this->makePattern();
    $source->name = "one-two";
    $pattern = new Pattern($source);
    $this->assertEquals('One Two', $pattern->getName());
  }

  public function testPartial() {
    $source = $this->makePattern();
    $source->partial = "one-two";
    $pattern = new Pattern($source);
    $this->assertEquals($source->partial, $pattern->getPartial());
  }

  public function testPath() {
    $source = $this->makePattern();
    $source->path = "one/two/three";
    $pattern = new Pattern($source);
    $this->assertEquals("one-two-three/one-two-three.html", $pattern->getPath());
  }

  public function testSourcePath() {
    $source = $this->makePattern();
    $source->path = "one/two/three";
    $pattern = new Pattern($source);
    $this->assertEquals($source->path, $pattern->getSourcePath());
  }

  public function testState() {
    $source = $this->makePattern();
    $source->state = "completed";
    $pattern = new Pattern($source);
    $this->assertEquals($source->state, $pattern->getState());
  }

  protected function makePattern() {
    return new \Labcoat\Mocks\Patterns\Pattern();
  }
}