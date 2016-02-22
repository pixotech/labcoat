<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

use Labcoat\Mocks\PatternLab;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testFile() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one/two/three', __FILE__);
    $this->assertEquals(__FILE__, $pattern->getFile());
  }

  # ID

  public function testId() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one/two/three', __FILE__);
    $this->assertEquals('one-two-three', $pattern->getId());
  }

  public function testIdContainsOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, '01-one/02-two/03-three', __FILE__);
    $this->assertEquals('01-one-02-two-03-three', $pattern->getId());
  }

  # Label

  public function testLabel() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'pattern', __FILE__);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testLabelDoesntHaveOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, '01-pattern', __FILE__);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testLabelWithType() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/pattern', __FILE__);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testLabelWithTypeDoesntHaveOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/01-pattern', __FILE__);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testLabelWithSubtype() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/subtype/pattern', __FILE__);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testLabelWithSubtypeDoesntHaveOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/subtype/01-pattern', __FILE__);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testLabelWithLotsOfNesting() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/subtype/pattern/one/two/and-three/and-four', __FILE__);
    $this->assertEquals('Pattern One Two And Three And Four', $pattern->getLabel());
  }

  # Name

  public function testName() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'pattern', __FILE__);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameDoesNotHaveOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, '01-pattern', __FILE__);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameWithType() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/pattern', __FILE__);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameWithTypeDoesNotHaveOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/01-pattern', __FILE__);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameWithSubtype() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/subtype/pattern', __FILE__);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameWithSubtypeDoesNotHaveOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/subtype/01-pattern', __FILE__);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameWithLotsOfNesting() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/subtype/pattern/one/two/and-three/and-four', __FILE__);
    $this->assertEquals('pattern-one-two-and-three-and-four', $pattern->getName());
  }

  public function testNameWithLotsOfNestingDoesntHaveOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/subtype/pattern/01-one/02-two/03-three/04-four', __FILE__);
    $this->assertEquals('pattern-one-two-three-four', $pattern->getName());
  }

  # Partial

  public function testPartial() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one/two/three', __FILE__);
    $this->assertEquals('one-three', $pattern->getPartial());
  }

  public function testPartialDoesntHaveOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, '01-one/02-two/03-three', __FILE__);
    $this->assertEquals('one-three', $pattern->getPartial());
  }

  # Path

  public function testPath() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one/two/three', __FILE__);
    $this->assertEquals('one/two/three', $pattern->getPath());
  }

  public function testPathHasDigits() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, '01-one/02-two/03-three', __FILE__);
    $this->assertEquals('01-one/02-two/03-three', $pattern->getPath());
  }

  # State

  public function testNoDefaultState() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one', __FILE__);
    $this->assertFalse($pattern->hasState());
  }

  # Description

  public function testDescription() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one', __FILE__);
    $this->assertEmpty($pattern->getDescription());
  }

  # Matches

  public function testMatchPartial() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one/two/three', __FILE__);
    $this->assertTrue($pattern->matches('one-three'));
  }

  public function testMatchPath() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one/two/three', __FILE__);
    $this->assertTrue($pattern->matches('one/two/three'));
  }

  public function testMatchPathWithOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, '01-one/02-two/03-three', __FILE__);
    $this->assertTrue($pattern->matches('one/two/three'));
  }

  public function testMatchPathWithoutOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one/two/three', __FILE__);
    $this->assertTrue($pattern->matches('01-one/02-two/03-three'));
  }
}