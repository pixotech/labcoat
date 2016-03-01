<?php

namespace Labcoat\PatternLab\Styleguide\Types;

class TypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $name = 'one';
    $type = new Type($name);
    $this->assertEquals($name, $type->getName());
  }

  public function testNameDoesntHaveOrdering() {
    $name = '01-one';
    $type = new Type($name);
    $this->assertEquals('one', $type->getName());
  }

  public function testLabel() {
    $name = 'the-label';
    $type = new Type($name);
    $this->assertEquals('The Label', $type->getLabel());
  }

  public function testLabelDoesntHaveOrdering() {
    $name = '01-the-label';
    $type = new Type($name);
    $this->assertEquals('The Label', $type->getLabel());
  }
}