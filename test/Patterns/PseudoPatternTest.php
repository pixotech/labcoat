<?php

namespace Labcoat\Patterns;

use Labcoat\Mocks\Patterns\Pattern;

class PseudoPatternTest extends \PHPUnit_Framework_TestCase {

  public function testDisplayName() {
    $pattern = new Pattern();
    $pattern->displayName = 'One';
    $pseudo = new PseudoPattern($pattern, 'two', __FILE__);
    $this->assertEquals('One Two', $pseudo->getDisplayName());
  }

  public function testFile() {
    $pattern = new Pattern();
    $pattern->file = __FILE__;
    $pseudo = new PseudoPattern($pattern, 'two', __FILE__);
    $this->assertEquals(__FILE__, $pseudo->getFile());
  }

  public function testName() {
    $pattern = new Pattern();
    $pattern->name = 'one';
    $pseudo = new PseudoPattern($pattern, 'two', __FILE__);
    $this->assertEquals('one', $pseudo->getName());
  }

  public function testPartial() {
    $pattern = new Pattern();
    $pattern->partial = 'one-two';
    $pseudo = new PseudoPattern($pattern, 'three', __FILE__);
    $this->assertEquals('one-two', $pseudo->getPartial());
  }

  public function testPath() {
    $pattern = new Pattern();
    $pattern->path = 'one/two/three';
    $pseudo = new PseudoPattern($pattern, 'four', __FILE__);
    $this->assertEquals('one/two/three', $pseudo->getPath());
  }

  public function testStyleguidePathName() {
    $pattern = new Pattern();
    $pattern->styleguidePathName = 'one-two';
    $pseudo = new PseudoPattern($pattern, 'three', __FILE__);
    $this->assertEquals('one-two-three', $pseudo->getStyleguidePathName());
  }

  public function testSubType() {
    $pattern = new Pattern();
    $pattern->subType = 'subtype';
    $pseudo = new PseudoPattern($pattern, 'name', __FILE__);
    $this->assertEquals('subtype', $pseudo->getSubType());
  }

  public function testType() {
    $pattern = new Pattern();
    $pattern->type = 'type';
    $pseudo = new PseudoPattern($pattern, 'name', __FILE__);
    $this->assertEquals('type', $pseudo->getType());
  }

  public function testHasSubType() {
    $pattern = new Pattern();
    $pattern->subType = 'subtype';
    $pseudo = new PseudoPattern($pattern, 'name', __FILE__);
    $this->assertTrue($pseudo->hasSubType());
  }
}