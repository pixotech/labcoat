<?php

namespace Labcoat\PatternLab\Patterns\Types;

use Labcoat\Mocks\PatternLab\Patterns\Types\Type;

class SubtypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $type = new Type();
    $subtype = new Subtype($type, 'one');
    $this->assertEquals('one', $subtype->getName());
  }

  public function testNameDoesNotHaveDigits() {
    $type = new Type();
    $subtype = new Subtype($type, '01-one');
    $this->assertEquals('one', $subtype->getName());
  }
}