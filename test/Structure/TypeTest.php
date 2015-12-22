<?php

namespace Labcoat\Structure;

class TypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $type = new Type('one');
    $this->assertEquals('one', $type->getName());
  }

  public function testNameDoesNotHaveDigits() {
    $type = new Type('01-one');
    $this->assertEquals('one', $type->getName());
  }
}