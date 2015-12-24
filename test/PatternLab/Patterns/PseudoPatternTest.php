<?php

namespace Labcoat\PatternLab\Patterns;

use Labcoat\Mocks\PatternLab\Patterns\Pattern;

class PseudoPatternTest extends \PHPUnit_Framework_TestCase {

  public function testId() {
    $pattern = new Pattern();
    $pattern->path = 'one/two/three';
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
    $this->assertEquals('pattern variant', $pseudo->getName());
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
    $pattern->path = 'one/two/three';
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