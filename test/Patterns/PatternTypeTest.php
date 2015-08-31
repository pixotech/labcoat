<?php

namespace Labcoat\Patterns;

class PatternTypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $type = new PatternType('one');
    $this->assertEquals('one', $type->getName());
  }

  public function testNameHasDigits() {
    $type = new PatternType('01-one');
    $this->assertEquals('01-one', $type->getName());
  }
}