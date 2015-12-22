<?php

namespace Labcoat\Structure;

use Labcoat\Mocks\Structure\Type;

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