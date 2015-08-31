<?php

namespace Labcoat\Patterns;

use Labcoat\Mocks\Patterns\Pattern;

class PseudoPatternTest extends \PHPUnit_Framework_TestCase {

  public function testId() {
    $pattern = new Pattern();
    $pattern->id = 'one/two/three';
    $pseudo = new PseudoPattern($pattern, 'four', __FILE__);
    $this->assertEquals("one/two/three~four", $pseudo->getId());
  }

  public function testFile() {
    $pattern = new Pattern();
    $pattern->file = __FILE__;
    $pseudo = new PseudoPattern($pattern, 'name', __FILE__);
    $this->assertEquals(__FILE__, $pseudo->getFile());
  }

  # Name

  public function testName() {
    $pattern = new Pattern();
    $pattern->name = 'pattern';
    $pseudo = new PseudoPattern($pattern, 'variant', __FILE__);
    $this->assertEquals('pattern-variant', $pseudo->getName());
  }

  # Type

  public function testType() {
    $pattern = new Pattern();
    $pattern->type = 'type';
    $pseudo = new PseudoPattern($pattern, 'variant', __FILE__);
    $this->assertEquals($pattern->type, $pseudo->getType());
  }

  # Subtype

  public function testHasSubType() {
    $pattern = new Pattern();
    $pattern->subtype = 'subtype';
    $pseudo = new PseudoPattern($pattern, 'variant', __FILE__);
    $this->assertTrue($pseudo->hasSubType());
  }

  public function testDoesntHaveSubType() {
    $pattern = new Pattern();
    $pseudo = new PseudoPattern($pattern, 'variant', __FILE__);
    $this->assertFalse($pseudo->hasSubType());
  }

  public function testSubType() {
    $pattern = new Pattern();
    $pattern->subtype = 'subtype';
    $pseudo = new PseudoPattern($pattern, 'variant', __FILE__);
    $this->assertEquals($pattern->subtype, $pseudo->getSubType());
  }

  # Partial

  public function testPartial() {
    $pattern = new Pattern();
    $pattern->partial = 'one-two';
    $pseudo = new PseudoPattern($pattern, 'three', __FILE__);
    $this->assertEquals('one-two-three', $pseudo->getPartial());
  }

  # Path


  public function testPath() {
    $pattern = new Pattern();
    $pattern->id = 'one/two/three';
    $pseudo = new PseudoPattern($pattern, 'four', __FILE__);
    $this->assertEquals('one/two/three~four', $pseudo->getPath());
  }

  # State

  public function testState() {
    $pattern = new Pattern();
    $pattern->state = 'completed';
    $pseudo = new PseudoPattern($pattern, 'variant', __FILE__);
    $this->assertEquals($pattern->state, $pseudo->getState());
  }
}