<?php

namespace Labcoat\PatternLab\Styleguide\Types;

use Labcoat\Mocks\PatternLab\Patterns\Pattern;
use Labcoat\Mocks\PatternLab\Styleguide\Types\Type;

class SubtypeTest extends \PHPUnit_Framework_TestCase {

  public function testType() {
    $type = new Type();
    $subtype = new Subtype($type, 'one');
    $this->assertEquals($type, $subtype->getType());
  }

  public function testName() {
    $name = 'one';
    $subtype = new Subtype(new Type(), $name);
    $this->assertEquals($name, $subtype->getName());
  }

  public function testNameHasOrdering() {
    $name = '01-one';
    $subtype = new Subtype(new Type(), $name);
    $this->assertEquals($name, $subtype->getName());
  }

  public function testLabel() {
    $name = 'the-label';
    $subtype = new Subtype(new Type(), $name);
    $this->assertEquals('The Label', $subtype->getLabel());
  }

  public function testLabelDoesntHaveOrdering() {
    $name = '01-the-label';
    $subtype = new Subtype(new Type(), $name);
    $this->assertEquals('The Label', $subtype->getLabel());
  }

  public function testPartial() {
    $type = new Type();
    $type->name = 'typename';
    $name = 'subtypename';
    $subtype = new Subtype($type, $name);
    $this->assertEquals("viewall-{$type->name}-{$name}", $subtype->getPartial());
  }

  public function testStyleguideDirectoryName() {
    $type = new Type();
    $type->name = 'typename';
    $name = 'subtypename';
    $subtype = new Subtype($type, $name);
    $this->assertEquals("{$type->name}-{$name}", $subtype->getStyleguideDirectoryName());
  }

  public function testAddPattern() {
    $pattern = new Pattern();
    $subtype = new Subtype(new Type(), 'subtype');
    $subtype->addPattern($pattern);
    $this->assertEquals([$pattern], $subtype->getPatterns());
  }
}