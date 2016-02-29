<?php

namespace Labcoat\PatternLab\Styleguide\Patterns;

use Labcoat\Mocks\PatternLab\Styleguide\Patterns\PatternRenderer as MockPatternRenderer;
use Labcoat\Mocks\PatternLab\Patterns\Pattern as PatternSource;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testLabel() {
    $source = new PatternSource();
    $source->label = 'Pattern';
    $pattern = new Pattern($source, new MockPatternRenderer());
    $this->assertEquals('Pattern', $pattern->getLabel());
  }

  public function testName() {
    $source = new PatternSource();
    $source->name = 'pattern';
    $pattern = new Pattern($source, new MockPatternRenderer());
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testNameDoesNotHaveOrdering() {
    $source = new PatternSource();
    $source->name = '01-pattern';
    $pattern = new Pattern($source, new MockPatternRenderer());
    $this->assertEquals('pattern', $pattern->getName());
  }

  public function testPartial() {
    $source = new PatternSource();
    $source->type = 'one';
    $source->name = 'three';
    $pattern = new Pattern($source, new MockPatternRenderer());
    $this->assertEquals('one-three', $pattern->getPartial());
  }

  public function testPartialDoesntHaveOrdering() {
    $source = new PatternSource();
    $source->type = '01-one';
    $source->name = '03-three';
    $pattern = new Pattern($source, new MockPatternRenderer());
    $this->assertEquals('one-three', $pattern->getPartial());
  }

  public function testState() {
    $source = new PatternSource();
    $source->state = 'state';
    $pattern = new Pattern($source, new MockPatternRenderer());
    $this->assertEquals($source->state, $pattern->getState());
  }

  public function testNoDefaultState() {
    $source = new PatternSource();
    $pattern = new Pattern($source, new MockPatternRenderer());
    $this->assertFalse($pattern->hasState());
  }

  public function testDescription() {
    $source = new PatternSource();
    $source->description = "This is the description";
    $pattern = new Pattern($source, new MockPatternRenderer());
    $this->assertEquals($source->description, $pattern->getDescription());
  }
}