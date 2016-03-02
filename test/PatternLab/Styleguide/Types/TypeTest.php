<?php

namespace Labcoat\PatternLab\Styleguide\Types;

use Labcoat\Mocks\PatternLab\Patterns\Pattern;

class TypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $name = 'one';
    $type = new Type($name);
    $this->assertEquals($name, $type->getName());
  }

  public function testNameHasOrdering() {
    $name = '01-one';
    $type = new Type($name);
    $this->assertEquals($name, $type->getName());
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

  public function testPartial() {
    $name = 'typename';
    $type = new Type($name);
    $this->assertEquals("viewall-{$name}-all", $type->getPartial());
  }

  public function testStyleguideDirectoryName() {
    $name = 'typename';
    $type = new Type($name);
    $this->assertEquals($name, $type->getStyleguideDirectoryName());
  }

  public function testAddPattern() {
    $pattern = new Pattern();
    $type = new Type('type');
    $type->addPattern($pattern);
    $this->assertEquals([$pattern], $type->getPatterns());
  }

  public function testAddPatternWithSubtype() {
    $pattern = new Pattern();
    $pattern->subtype = 'subtype';
    $type = new Type('type');
    $type->addPattern($pattern);
    $this->assertTrue($type->hasSubtypes());
    $subtypes = $type->getSubTypes();
    $this->assertArrayHasKey($pattern->subtype, $subtypes);
  }

  public function testAddPatternWithoutSubtype() {
    $pattern = new Pattern();
    $type = new Type('type');
    $type->addPattern($pattern);
    $this->assertFalse($type->hasSubtypes());
  }
}