<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\Mocks\Patterns\Subtype as SourceSubtype;

class SubtypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $source = new SourceSubtype();
    $source->path = 'type/one';
    $subtype = new Subtype($source);
    $this->assertEquals('one', $subtype->getName());
  }

  public function testNameWithDashes() {
    $source = new SourceSubtype();
    $source->path = 'type/name-with-dashes';
    $subtype = new Subtype($source);
    $this->assertEquals('name-with-dashes', $subtype->getNameWithDashes());
  }

  public function testNameWithDashesDoesntHaveDigits() {
    $source = new SourceSubtype();
    $source->path = 'type/01-name-with-dashes';
    $subtype = new Subtype($source);
    $this->assertEquals('name-with-dashes', $subtype->getNameWithDashes());
  }

  public function testLowercaseName() {
    $source = new SourceSubtype();
    $source->path = 'type/name-with-dashes';
    $subtype = new Subtype($source);
    $this->assertEquals('name with dashes', $subtype->getLowercaseName());
  }

  public function testLowercaseNameDoesntHaveDigits() {
    $source = new SourceSubtype();
    $source->path = 'type/01-name-with-dashes';
    $subtype = new Subtype($source);
    $this->assertEquals('name with dashes', $subtype->getLowercaseName());
  }

  public function testUppercaseName() {
    $source = new SourceSubtype();
    $source->path = 'type/name-with-dashes';
    $subtype = new Subtype($source);
    $this->assertEquals('Name With Dashes', $subtype->getUppercaseName());
  }

  public function testUppercaseNameDoesntHaveDigits() {
    $source = new SourceSubtype();
    $source->path = 'type/01-name-with-dashes';
    $subtype = new Subtype($source);
    $this->assertEquals('Name With Dashes', $subtype->getUppercaseName());
  }
}