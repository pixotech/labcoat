<?php

namespace Labcoat\Paths;

class SegmentTest extends \PHPUnit_Framework_TestCase {

  public function testString() {
    $str = 'segment';
    $segment = new Segment($str);
    $this->assertEquals($str, (string)$segment);
  }

  public function testStringWithOrdering() {
    $str = '01-segment';
    $segment = new Segment($str);
    $this->assertEquals($str, (string)$segment);
  }

  public function testName() {
    $name = 'segment';
    $segment = new Segment($name);
    $this->assertEquals($name, $segment->getName());
  }

  public function testOrdering() {
    $ordering = '01';
    $name = 'segment';
    $segment = new Segment("{$ordering}-{$name}");
    $this->assertEquals($ordering, $segment->getOrdering());
  }

  public function testNoOrdering() {
    $name = 'segment';
    $segment = new Segment($name);
    $this->assertNull($segment->getOrdering());
  }

  public function testNameFromPathWithOrdering() {
    $name = 'segment';
    $segment = new Segment("01-{$name}");
    $this->assertEquals($name, $segment->getName());
  }
}