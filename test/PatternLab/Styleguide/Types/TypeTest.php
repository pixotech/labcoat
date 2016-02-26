<?php

namespace Labcoat\PatternLab\Styleguide\Types;

class TypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $name = 'one';
    $type = new Type($name);
    $this->assertEquals($name, $type->getName());
  }
}