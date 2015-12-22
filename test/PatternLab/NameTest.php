<?php

namespace Labcoat\PatternLab;

class NameTest extends \PHPUnit_Framework_TestCase {

  public function testNameString() {
    $str = 'segment';
    $name = new Name($str);
    $this->assertEquals($str, (string)$name);
  }

  public function testNameStringDoesNotHaveOrdering() {
    $str = 'segment';
    $name = new Name("01-{$str}");
    $this->assertEquals($str, (string)$name);
  }

  public function testOrdering() {
    $ordering = 1;
    $str = 'segment';
    $name = new Name(sprintf("%02d-%s", $ordering, $str));
    $this->assertTrue($name->hasOrdering());
    $this->assertSame($ordering, $name->getOrdering());
  }

  public function testNoOrdering() {
    $str = 'segment';
    $name = new Name($str);
    $this->assertFalse($name->hasOrdering());
    $this->assertNull($name->getOrdering());
  }
}