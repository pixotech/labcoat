<?php

namespace Labcoat\Patterns\Paths;

class PathTest extends \PHPUnit_Framework_TestCase {

  public function testSplitPathWithForwardSlashes() {
    $path = 'one/two/three';
    $segments = Path::split($path);
    $this->assertEquals(count($segments), 3);
  }

  public function testSplitPathWithBackwardSlashes() {
    $path = 'one\two\three';
    $segments = Path::split($path);
    $this->assertEquals(count($segments), 3);
  }

  public function testString() {
    $str = 'path';
    $path = new Path($str);
    $this->assertEquals($str, (string)$path);
  }

  public function testStringWithOrdering() {
    $str = '01-one/02-two/03-three';
    $path = new Path($str);
    $this->assertEquals($str, (string)$path);
  }

  public function testStringDelimiter() {
    $segments = ['one', 'two', 'three'];
    $str = implode(DIRECTORY_SEPARATOR, $segments);
    $path = new Path($str);
    $this->assertEquals(implode(Path::DELIMITER, $segments), (string)$path);
  }

  public function testType() {
    $path = new Path('type/name');
    $this->assertEquals('type', $path->getType());
  }

  public function testTypeWithOrdering() {
    $path = new Path('01-type/name');
    $this->assertEquals('01-type', $path->getType());
  }

  public function testHasType() {
    $path = new Path('type/name');
    $this->assertTrue($path->hasType());
  }

  public function testDoesntHaveType() {
    $path = new Path('name');
    $this->assertFalse($path->hasType());
  }

  public function testSubtype() {
    $path = new Path('type/subtype/name');
    $this->assertEquals('subtype', $path->getSubtype());
  }

  public function testSubtypeWithOrdering() {
    $path = new Path('type/02-subtype/name');
    $this->assertEquals('02-subtype', $path->getSubtype());
  }

  public function testHasSubtype() {
    $path = new Path('type/subtype/name');
    $this->assertTrue($path->hasSubtype());
  }

  public function testDoesntHaveSubtype() {
    $path = new Path('name');
    $this->assertFalse($path->hasSubtype());
  }

  public function testHasTypeButDoesntHaveSubtype() {
    $path = new Path('type/name');
    $this->assertFalse($path->hasSubtype());
  }

  public function testName() {
    $path = new Path('name');
    $this->assertEquals('name', $path->getName());
  }

  public function testNameOfPatternWithType() {
    $path = new Path('type/name');
    $this->assertEquals('name', $path->getName());
  }

  public function testNameOfPatternWithSubtype() {
    $path = new Path('type/subtype/name');
    $this->assertEquals('name', $path->getName());
  }

  public function testNameOfPatternWithFourSegments() {
    $path = new Path('type/subtype/one/two');
    $this->assertEquals('one--two', $path->getName());
  }

  public function testNormalize() {
    $path = new Path('01-one/02-two/03-three');
    $this->assertEquals('one/two/three', (string)$path->normalize());
  }
}