<?php

namespace Labcoat\Patterns;

use Labcoat\Sections\Type;

class TypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $type = new Type('one');
    $this->assertEquals('one', $type->getName());
  }

  public function testNameHasDigits() {
    $type = new Type('01-one');
    $this->assertEquals('01-one', $type->getName());
  }
}