<?php

namespace Labcoat\PatternLab\Styleguide\Types;

use Labcoat\PatternLab\Name;

class TypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $name = new Name('one');
    $type = new Type($name);
    $this->assertEquals($name, $type->getName());
  }
}