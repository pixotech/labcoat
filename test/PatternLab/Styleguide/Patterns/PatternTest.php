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

  # ID

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

  # Label

  public function testLabel() {
    $source = new PatternSource();
    $source->label = 'Pattern';
    $pattern = new Pattern($source);
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  # Name

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

  # Partial

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

  # Path

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

  # State

  public function testNoDefaultState() {
    $source = new PatternSource();
    $pattern = new Pattern($source);
    $this->assertFalse($pattern->hasState());
  }

  # Description

  public function testDescription() {
    $source = new PatternSource();
    $pattern = new Pattern($source);
    $this->assertEmpty($pattern->getDescription());
  }

  # Matches

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