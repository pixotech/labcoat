<?php

namespace Labcoat\Styleguide\Patterns;

use Labcoat\Mocks\PatternLab;
use Labcoat\Mocks\Patterns\Pattern as SourcePattern;
use Labcoat\Mocks\Patterns\PseudoPattern;
use Labcoat\Mocks\Styleguide\Styleguide;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testId() {
    $source = $this->makeSourcePattern();
    $source->id = 'id';
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals($source->id, $pattern->getId());
  }

  public function testName() {
    $source = $this->makeSourcePattern();
    $source->name = 'name';
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals("Name", $pattern->getName());
  }

  public function testFile() {
    $source = $this->makeSourcePattern();
    $source->file = 'file';
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals($source->file, $pattern->getFile());
  }

  public function testPath() {
    $source = $this->makeSourcePattern();
    $source->path = 'one/two/three';
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $path = 'one-two-three' . DIRECTORY_SEPARATOR . "one-two-three.html";
    $this->assertEquals($path, $pattern->getPath());
  }

  public function testTemplate() {
    $source = $this->makeSourcePattern();
    $source->template = 'template';
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals($source->template, $pattern->getTemplate());
  }

  public function testPatternDesc() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals('', $pattern->getDescription());
  }

  protected function makePseudoPattern() {
    return new PseudoPattern();
  }

  protected function makeStyleguide() {
    $styleguide = new Styleguide();
    $styleguide->patternlab = new PatternLab();
    return $styleguide;
  }

  protected function makeSourcePattern() {
    return new SourcePattern();
  }
}