<?php

namespace Labcoat\PatternLab\Patterns\Types;

use Labcoat\PatternLab\Patterns\Pattern;

class SubtypeTest extends \PHPUnit_Framework_TestCase {

  public function testType() {
    $type = new Type('type');
    $subtype = new Subtype($type, 'one');
    $this->assertEquals($type, $subtype->getType());
  }

  public function testName() {
    $name = 'one';
    $subtype = new Subtype(new Type('type'), $name);
    $this->assertEquals($name, $subtype->getName());
  }

  public function testNameHasOrdering() {
    $name = '01-one';
    $subtype = new Subtype(new Type('type'), $name);
    $this->assertEquals($name, $subtype->getName());
  }

  public function testLabel() {
    $name = 'the-label';
    $subtype = new Subtype(new Type('type'), $name);
    $this->assertEquals('The Label', $subtype->getLabel());
  }

  public function testLabelDoesntHaveOrdering() {
    $name = '01-the-label';
    $subtype = new Subtype(new Type('type'), $name);
    $this->assertEquals('The Label', $subtype->getLabel());
  }

  public function testPartial() {
    $typename = 'typename';
    $type = new Type($typename);
    $name = 'subtypename';
    $subtype = new Subtype($type, $name);
    $this->assertEquals("viewall-{$typename}-{$name}", $subtype->getPartial());
  }

  public function testAddPattern() {
    $pattern = new Pattern('name', 'type');
    $subtype = new Subtype(new Type('type'), 'subtype');
    $subtype->addPattern($pattern);
    $this->assertEquals([$pattern], $subtype->getPatterns());
  }
}