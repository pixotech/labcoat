<?php

namespace Labcoat\Patterns;

use Labcoat\Mocks\Patterns\PatternType;

class PatternSubTypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $type = new PatternType();
    $subtype = new PatternSubType($type, 'one');
    $this->assertEquals('one', $subtype->getName());
  }

  public function testNameHasDigits() {
    $type = new PatternType();
    $subtype = new PatternSubType($type, '01-one');
    $this->assertEquals('01-one', $subtype->getName());
  }

  public function testType() {
    $type = new PatternType();
    $subtype = new PatternSubType($type, 'one');
    $this->assertEquals($type, $subtype->getType());
  }
}