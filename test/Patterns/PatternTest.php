<?php

namespace Labcoat\Patterns;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testDisplayName() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals('Three', $pattern->getDisplayName());
  }

  public function testFile() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals(__FILE__, $pattern->getFile());
  }

  public function testName() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals('three', $pattern->getName());
  }

  public function testPartial() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals('one-three', $pattern->getPartial());
  }

  public function testPath() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals('one/two/three', $pattern->getPath());
  }

  public function testStyleguidePathName() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals('one-two-three', $pattern->getStyleguidePathName());
  }

  public function testSubType() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals('two', $pattern->getSubType());
  }

  public function testType() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals('one', $pattern->getType());
  }

  public function testHasSubType() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertTrue($pattern->hasSubType());
  }
}