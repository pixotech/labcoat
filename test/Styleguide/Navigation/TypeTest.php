<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Mocks\Structure\Type as SourceType;

class TypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $name = 'one';
    $type = new Type($this->makeSource($name));
    $this->assertEquals($name, $type->getName());
  }

  public function testUppercaseName() {
    $type = new Type($this->makeSource('one-two'));
    $this->assertEquals('One Two', $type->getUppercaseName());
  }

  public function testLowercaseName() {
    $type = new Type($this->makeSource('one-two'));
    $this->assertEquals('one two', $type->getLowercaseName());
  }

  protected function makeSource($name) {
    $type = new SourceType();
    $type->name = $name;
    return $type;
  }
}