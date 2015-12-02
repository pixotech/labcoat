<?php

namespace Labcoat\Patterns;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testFile() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals(__FILE__, $pattern->getFile());
  }

  # ID

  public function testId() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals('one-two-three', $pattern->getId());
  }

  public function testIdContainsOrdering() {
    $pattern = new Pattern('01-one/02-two/03-three', __FILE__);
    $this->assertEquals('01-one-02-two-03-three', $pattern->getId());
  }

  # Label

  public function testLabel() {
    $pattern = new Pattern('pattern', __FILE__);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testLabelDoesntHaveOrdering() {
    $pattern = new Pattern('01-pattern', __FILE__);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testLabelWithType() {
    $pattern = new Pattern('type/pattern', __FILE__);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testLabelWithTypeDoesntHaveOrdering() {
    $pattern = new Pattern('type/01-pattern', __FILE__);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testLabelWithSubtype() {
    $pattern = new Pattern('type/subtype/pattern', __FILE__);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testLabelWithSubtypeDoesntHaveOrdering() {
    $pattern = new Pattern('type/subtype/01-pattern', __FILE__);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testLabelWithLotsOfNesting() {
    $pattern = new Pattern('type/subtype/pattern/one/two/and-three/and-four', __FILE__);
    $this->assertEquals('Pattern One Two And Three And Four', $pattern->getLabel());
  }

  public function testLabelWithLotsOfNestingDoesntHaveOrdering() {
    $pattern = new Pattern('type/subtype/pattern/01-one/02-two/03-three/04-four', __FILE__);
    $this->assertEquals('Pattern One Two Three Four', $pattern->getLabel());
  }

  # Name

  public function testName() {
    $pattern = new Pattern('pattern', __FILE__);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameHasOrdering() {
    $pattern = new Pattern('01-pattern', __FILE__);
    $this->assertEquals('01-pattern', $pattern->getName());
  }

  public function testNameWithType() {
    $pattern = new Pattern('type/pattern', __FILE__);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameWithTypeHasOrdering() {
    $pattern = new Pattern('type/01-pattern', __FILE__);
    $this->assertEquals('01-pattern', $pattern->getName());
  }

  public function testNameWithSubtype() {
    $pattern = new Pattern('type/subtype/pattern', __FILE__);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameWithSubtypeHasOrdering() {
    $pattern = new Pattern('type/subtype/01-pattern', __FILE__);
    $this->assertEquals('01-pattern', $pattern->getName());
  }

  public function testNameWithLotsOfNesting() {
    $pattern = new Pattern('type/subtype/pattern/one/two/and-three/and-four', __FILE__);
    $this->assertEquals('pattern-one-two-and-three-and-four', $pattern->getName());
  }

  public function testNameWithLotsOfNestingHasOrdering() {
    $pattern = new Pattern('type/subtype/pattern/01-one/02-two/03-three/04-four', __FILE__);
    $this->assertEquals('pattern-01-one-02-two-03-three-04-four', $pattern->getName());
  }

  # Partial

  public function testPartial() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals('one-three', $pattern->getPartial());
  }

  # Path

  public function testPath() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals('one/two/three', $pattern->getPath());
  }

  public function testPathHasDigits() {
    $pattern = new Pattern('01-one/02-two/03-three', __FILE__);
    $this->assertEquals('01-one/02-two/03-three', $pattern->getPath());
  }
}