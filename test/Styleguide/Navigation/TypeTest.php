<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Mocks\Patterns\PatternType;

class TypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $source = new PatternType();
    $source->name = 'one';
    $type = new Type($source);
    $this->assertEquals('one', $type->getName());
  }

  public function testNameWithDashes() {
    $source = new PatternType();
    $source->name = 'name-with-dashes';
    $type = new Type($source);
    $this->assertEquals('name-with-dashes', $type->getNameWithDashes());
  }

  public function testNameWithDashesDoesntHaveDigits() {
    $source = new PatternType();
    $source->name = '01-name-with-dashes';
    $type = new Type($source);
    $this->assertEquals('name-with-dashes', $type->getNameWithDashes());
  }

  public function testLowercaseName() {
    $source = new PatternType();
    $source->name = 'name-with-dashes';
    $type = new Type($source);
    $this->assertEquals('name with dashes', $type->getLowercaseName());
  }

  public function testLowercaseNameDoesntHaveDigits() {
    $source = new PatternType();
    $source->name = '01-name-with-dashes';
    $type = new Type($source);
    $this->assertEquals('name with dashes', $type->getLowercaseName());
  }

  public function testUppercaseName() {
    $source = new PatternType();
    $source->name = 'name-with-dashes';
    $type = new Type($source);
    $this->assertEquals('Name With Dashes', $type->getUppercaseName());
  }

  public function testUppercaseNameDoesntHaveDigits() {
    $source = new PatternType();
    $source->name = '01-name-with-dashes';
    $type = new Type($source);
    $this->assertEquals('Name With Dashes', $type->getUppercaseName());
  }
}