<?php

namespace Labcoat\Mocks\PatternLab\Styleguide\Types;

class TypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $name = 'type-name';
    $type = new Type();
    $type->name = $name;
    $this->assertEquals($name, $type->getName());
  }

  public function testPatterns() {
    $type = new Type('type-name');
    $this->assertEquals([], $type->getPatterns());
  }
}