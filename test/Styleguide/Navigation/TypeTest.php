<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Mocks\Patterns\Type as SourceType;

class TypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $source = new SourceType();
    $source->name = 'one';
    $type = new Type($source);
    $this->assertEquals('one', $type->getName());
  }

  public function testNameWithDashes() {
    $source = new SourceType();
    $source->name = 'name-with-dashes';
    $type = new Type($source);
    $this->assertEquals('name-with-dashes', $type->getNameWithDashes());
  }

  public function testNameWithDashesDoesntHaveDigits() {
    $source = new SourceType();
    $source->name = '01-name-with-dashes';
    $type = new Type($source);
    $this->assertEquals('name-with-dashes', $type->getNameWithDashes());
  }

  public function testLowercaseName() {
    $source = new SourceType();
    $source->name = 'name-with-dashes';
    $type = new Type($source);
    $this->assertEquals('name with dashes', $type->getLowercaseName());
  }

  public function testLowercaseNameDoesntHaveDigits() {
    $source = new SourceType();
    $source->name = '01-name-with-dashes';
    $type = new Type($source);
    $this->assertEquals('name with dashes', $type->getLowercaseName());
  }

  public function testUppercaseName() {
    $source = new SourceType();
    $source->name = 'name-with-dashes';
    $type = new Type($source);
    $this->assertEquals('Name With Dashes', $type->getUppercaseName());
  }

  public function testUppercaseNameDoesntHaveDigits() {
    $source = new SourceType();
    $source->name = '01-name-with-dashes';
    $type = new Type($source);
    $this->assertEquals('Name With Dashes', $type->getUppercaseName());
  }
}