<?php

namespace Labcoat\PatternLab\Styleguide\Types;

use Labcoat\Mocks\PatternLab\Styleguide\Types\Type;

class SubtypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $type = new Type();
    $name = 'one';
    $subtype = new Subtype($type, $name);
    $this->assertEquals($name, $subtype->getName());
  }
}