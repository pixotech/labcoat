<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

use Labcoat\Mocks\PatternLab;
use Labcoat\Mocks\PatternLab\Pattern as PatternSource;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testFile() {
    $source = new PatternSource();
    $source->file = __FILE__;
    $pattern = new Pattern($source);
    $this->assertEquals($source->file, $pattern->getFile());
  }

  public function testId() {
    $source = new PatternSource();
    $source->path = 'one/two/three';
    $pattern = new Pattern($source);
    $this->assertEquals('one-two-three', $pattern->getId());
  }

  public function testIdContainsOrdering() {
    $source = new PatternSource();
    $source->path = '01-one/02-two/03-three';
    $pattern = new Pattern($source);
    $this->assertEquals('01-one-02-two-03-three', $pattern->getId());
  }

  public function testLabel() {
    $source = new PatternSource();
    $source->label = 'Pattern';
    $pattern = new Pattern($source);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testName() {
    $source = new PatternSource();
    $source->name = 'pattern';
    $pattern = new Pattern($source);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameDoesNotHaveOrdering() {
    $source = new PatternSource();
    $source->name = '01-pattern';
    $pattern = new Pattern($source);
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testPartial() {
    $source = new PatternSource();
    $source->type = 'one';
    $source->name = 'three';
    $pattern = new Pattern($source);
    $this->assertEquals('one-three', $pattern->getPartial());
  }

  public function testPartialDoesntHaveOrdering() {
    $source = new PatternSource();
    $source->type = '01-one';
    $source->name = '03-three';
    $pattern = new Pattern($source);
    $this->assertEquals('one-three', $pattern->getPartial());
  }

  public function testPath() {
    $source = new PatternSource();
    $source->path = 'one/two/three';
    $pattern = new Pattern($source);
    $this->assertEquals('one/two/three', $pattern->getPath());
  }

  public function testPathHasDigits() {
    $source = new PatternSource();
    $source->path = '01-one/02-two/03-three';
    $pattern = new Pattern($source);
    $this->assertEquals('01-one/02-two/03-three', $pattern->getPath());
  }

  public function testState() {
    $source = new PatternSource();
    $source->state = 'state';
    $pattern = new Pattern($source);
    $this->assertEquals($source->state, $pattern->getState());
  }

  public function testNoDefaultState() {
    $source = new PatternSource();
    $pattern = new Pattern($source);
    $this->assertFalse($pattern->hasState());
  }

  public function testDescription() {
    $source = new PatternSource();
    $source->description = "This is the description";
    $pattern = new Pattern($source);
    $this->assertEquals($source->description, $pattern->getDescription());
  }

  public function testMatchPartial() {
    $source = new PatternSource();
    $source->type = 'one';
    $source->name = 'three';
    $pattern = new Pattern($source);
    $this->assertTrue($pattern->matches('one-three'));
  }

  public function testMatchPath() {
    $source = new PatternSource();
    $source->path = 'one/two/three';
    $pattern = new Pattern($source);
    $this->assertTrue($pattern->matches('one/two/three'));
  }

  public function testMatchPathWithOrdering() {
    $source = new PatternSource();
    $source->path = '01-one/02-two/03-three';
    $pattern = new Pattern($source);
    $this->assertTrue($pattern->matches('one/two/three'));
  }

  public function testMatchPathWithoutOrdering() {
    $source = new PatternSource();
    $source->path = 'one/two/three';
    $pattern = new Pattern($source);
    $this->assertTrue($pattern->matches('01-one/02-two/03-three'));
  }
}