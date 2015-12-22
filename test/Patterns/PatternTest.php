<?php

namespace Labcoat\Patterns;

use Labcoat\Mocks\PatternLab;
use Labcoat\Mocks\Patterns\Configuration\Configuration;

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

  public function testLabelWithLotsOfNestingDoesntHaveOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/subtype/pattern/01-one/02-two/03-three/04-four', __FILE__);
    $this->assertEquals('Pattern One Two Three Four', $pattern->getLabel());
  }

  public function testConfiguredLabel() {
    $label = 'custom label';
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one', __FILE__);
    $config = new Configuration();
    $config->label = $label;
    $pattern->setConfiguration($config);
    $this->assertEquals($label, $pattern->getLabel());
  }

  # Name

  public function testName() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'pattern', __FILE__);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameHasOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, '01-pattern', __FILE__);
    $this->assertEquals('01-pattern', $pattern->getName());
  }

  public function testNameWithType() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/pattern', __FILE__);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameWithTypeHasOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/01-pattern', __FILE__);
    $this->assertEquals('01-pattern', $pattern->getName());
  }

  public function testNameWithSubtype() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/subtype/pattern', __FILE__);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameWithSubtypeHasOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/subtype/01-pattern', __FILE__);
    $this->assertEquals('01-pattern', $pattern->getName());
  }

  public function testNameWithLotsOfNesting() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/subtype/pattern/one/two/and-three/and-four', __FILE__);
    $this->assertEquals('pattern-one-two-and-three-and-four', $pattern->getName());
  }

  public function testNameWithLotsOfNestingHasOrdering() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'type/subtype/pattern/01-one/02-two/03-three/04-four', __FILE__);
    $this->assertEquals('pattern-01-one-02-two-03-three-04-four', $pattern->getName());
  }

  public function testConfiguredName() {
    $name = 'custom name';
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one', __FILE__);
    $config = new Configuration();
    $config->name = $name;
    $pattern->setConfiguration($config);
    $this->assertEquals($name, $pattern->getName());
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

  public function testConfiguredState() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one', __FILE__);
    $config = new Configuration();
    $config->state = 'state';
    $pattern->setConfiguration($config);
    $this->assertTrue($pattern->hasState());
  }

  # Description

  public function testDescription() {
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one', __FILE__);
    $this->assertEmpty($pattern->getDescription());
  }

  public function testConfiguredDescription() {
    $description = 'custom description';
    $patternlab = new PatternLab();
    $pattern = new Pattern($patternlab, 'one', __FILE__);
    $config = new Configuration();
    $config->description = $description;
    $pattern->setConfiguration($config);
    $this->assertEquals($description, $pattern->getDescription());
  }
}