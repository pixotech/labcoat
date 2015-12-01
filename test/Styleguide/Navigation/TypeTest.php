<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Mocks\Structure\Type as SourceType;

class TypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $name = 'one';
    $source = $this->makeSource($name);
    $type = new Type($source);
    $this->assertEquals($name, $type->getName());
  }

  protected function makeSource($name) {
    $type = new SourceType();
    $type->name = $name;
    return $type;
  }
}