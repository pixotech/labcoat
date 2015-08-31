<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Mocks\Patterns\PatternSubType;

class SubtypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $source = new PatternSubType();
    $source->name = 'one';
    $subtype = new Subtype($source);
    $this->assertEquals('one', $subtype->getName());
  }

  public function testNameWithDashes() {
    $source = new PatternSubType();
    $source->name = 'name-with-dashes';
    $subtype = new Subtype($source);
    $this->assertEquals('name-with-dashes', $subtype->getNameWithDashes());
  }

  public function testNameWithDashesDoesntHaveDigits() {
    $source = new PatternSubType();
    $source->name = '01-name-with-dashes';
    $subtype = new Subtype($source);
    $this->assertEquals('name-with-dashes', $subtype->getNameWithDashes());
  }

  public function testLowercaseName() {
    $source = new PatternSubType();
    $source->name = 'name-with-dashes';
    $subtype = new Subtype($source);
    $this->assertEquals('name with dashes', $subtype->getLowercaseName());
  }

  public function testLowercaseNameDoesntHaveDigits() {
    $source = new PatternSubType();
    $source->name = '01-name-with-dashes';
    $subtype = new Subtype($source);
    $this->assertEquals('name with dashes', $subtype->getLowercaseName());
  }

  public function testUppercaseName() {
    $source = new PatternSubType();
    $source->name = 'name-with-dashes';
    $subtype = new Subtype($source);
    $this->assertEquals('Name With Dashes', $subtype->getUppercaseName());
  }

  public function testUppercaseNameDoesntHaveDigits() {
    $source = new PatternSubType();
    $source->name = '01-name-with-dashes';
    $subtype = new Subtype($source);
    $this->assertEquals('Name With Dashes', $subtype->getUppercaseName());
  }
}