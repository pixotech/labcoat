<?php

namespace Labcoat\PatternLab\Styleguide\Patterns\Types;

use Labcoat\Mocks\PatternLab\Styleguide\Patterns\Types\Type;
use Labcoat\PatternLab\Name;

class SubtypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $type = new Type();
    $name = new Name('one');
    $subtype = new Subtype($type, $name);
    $this->assertEquals($name, $subtype->getName());
  }
}