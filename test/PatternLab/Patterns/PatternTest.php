<?php

namespace Labcoat\PatternLab\Patterns;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testDescription() {
    $description = 'This is the description of the pattern';
    $pattern = $this->makePattern();
    $pattern->setDescription($description);
    $this->assertEquals($description, $pattern->getDescription());
  }

  public function testExample() {
    $example = '<p>This is the <dfn>pattern example</dfn>.</p>';
    $pattern = $this->makePattern();
    $pattern->setExample($example);
    $this->assertEquals($example, $pattern->getExample());
  }

  public function testLabel() {
    $label = 'Label';
    $pattern = $this->makePattern();
    $pattern->setLabel($label);
    $this->assertEquals($label, $pattern->getLabel());
  }

  public function testDefaultLabel() {
    $name = 'the-pattern-name';
    $pattern = $this->makePattern($name);
    $this->assertEquals("The Pattern Name", $pattern->getLabel());
  }

  public function testName() {
    $name = 'pattern-name';
    $pattern = $this->makePattern($name);
    $this->assertEquals($name, $pattern->getName());
  }

  /**
   * @expectedException \InvalidArgumentException
   */
  public function testNameCantBeEmpty() {
    $pattern = $this->makePattern();
    $pattern->setName('');
  }

  public function testState() {
    $state = 'state';
    $pattern = $this->makePattern();
    $pattern->setState($state);
    $this->assertTrue($pattern->hasState());
    $this->assertEquals($state, $pattern->getState());
  }

  public function testNoState() {
    $pattern = $this->makePattern();
    $this->assertFalse($pattern->hasState());
  }

  public function testSubtype() {
    $subtype = 'subtype';
    $pattern = $this->makePattern('name', 'type', $subtype);
    $this->assertEquals($subtype, $pattern->getSubtype());
  }

  public function testHasSubtype() {
    $subtype = 'subtype';
    $pattern = $this->makePattern('name', 'type', $subtype);
    $this->assertTrue($pattern->hasSubtype());
  }

  public function testNoSubtype() {
    $pattern = $this->makePattern('name', 'type');
    $this->assertFalse($pattern->hasSubtype());
  }

  public function testType() {
    $type = 'type';
    $pattern = $this->makePattern('name', $type);
    $this->assertEquals($type, $pattern->getType());
  }

  /**
   * @expectedException \InvalidArgumentException
   */
  public function testTypeCantBeEmpty() {
    $pattern = $this->makePattern();
    $pattern->setType('');
  }

  protected function makePattern($name = 'name', $type = 'type', $subtype = null) {
    return new Pattern($name, $type, $subtype);
  }
}