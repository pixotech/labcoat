<?php

namespace Labcoat\Patterns;

use Labcoat\Sections\Subtype;

class SubtypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $subtype = new Subtype('type/one');
    $this->assertEquals('one', $subtype->getName());
  }

  public function testNameDoesntHaveDigits() {
    $subtype = new Subtype('type/01-one');
    $this->assertEquals('one', $subtype->getName());
  }
}