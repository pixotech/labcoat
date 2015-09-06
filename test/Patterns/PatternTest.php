<?php

namespace Labcoat\Patterns;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testId() {
    $id = 'one/two/three';
    $pattern = new Pattern($id, __FILE__);
    $this->assertEquals($id, $pattern->getId());
  }

  public function testFile() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals(__FILE__, $pattern->getFile());
  }

  # Name

  public function testName() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals('three', $pattern->getName());
  }

  public function testNameHasDigits() {
    $pattern = new Pattern('01-one/02-two/03-three', __FILE__);
    $this->assertEquals('03-three', $pattern->getName());
  }

  # Partial

  public function testPartial() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals('one-three', $pattern->getPartial());
  }

  public function testPartialDoesntHaveDigits() {
    $pattern = new Pattern('01-one/02-two/03-three', __FILE__);
    $this->assertEquals('one-three', $pattern->getPartial());
  }

  # Path


  public function testPath() {
    $pattern = new Pattern('one/two/three', __FILE__);
    $this->assertEquals('one/two/three', $pattern->getPath());
  }

  public function testPathHasDigits() {
    $pattern = new Pattern('01-one/02-two/03-three', __FILE__);
    $this->assertEquals('01-one/02-two/03-three', $pattern->getPath());
  }

  # State

  public function testState() {
    $pattern = new Pattern('one/two/three@completed', __FILE__);
    $this->assertEquals('completed', $pattern->getState());
  }

  public function testNameWithState() {
    $pattern = new Pattern('one/two/three@completed', __FILE__);
    $this->assertEquals('three', $pattern->getName());
  }
}