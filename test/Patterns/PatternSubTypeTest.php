<?php

namespace Labcoat\Patterns;

class PatternSubTypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $subtype = new PatternType('one');
    $this->assertEquals('one', $subtype->getName());
  }

  public function testNameHasDigits() {
    $subtype = new PatternType('01-one');
    $this->assertEquals('01-one', $subtype->getName());
  }
}