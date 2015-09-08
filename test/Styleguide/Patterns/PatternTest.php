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

  public function testPatternCss() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertNull($pattern->patternCSS());
  }

  public function testPatternCssExists() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertFalse($pattern->patternCSSExists());
  }

  public function testPatternDesc() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals('', $pattern->patternDesc());
  }

  public function testPatternDescAdditions() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals([], $pattern->patternDescAdditions());
  }

  public function testPatternDescExists() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertFalse($pattern->patternDescExists());
  }

  public function testPatternEngineName() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals("Twig", $pattern->patternEngineName());
  }

  public function testPatternExampleAdditions() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals([], $pattern->patternExampleAdditions());
  }

  public function testPatternLineageExists() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertFalse($pattern->patternLineageExists());
  }

  public function testPatternLineageEExists() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertFalse($pattern->patternLineageEExists());
  }

  public function testPatternLineageRExists() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertFalse($pattern->patternLineageRExists());
  }

  public function testPatternLineages() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals([], $pattern->patternLineages());
  }

  public function testPatternLineagesR() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals([], $pattern->patternLineagesR());
  }

  public function testPatternLink() {
    $source = $this->makeSourcePattern();
    $source->path = 'type/subtype/name';
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $link = 'type-subtype-name' . DIRECTORY_SEPARATOR . 'type-subtype-name.html';
    $this->assertEquals($link, $pattern->patternLink());
  }

  public function testPatternName() {
    $source = $this->makeSourcePattern();
    $source->name = 'pattern-name';
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals("Pattern Name", $pattern->patternName());
  }

  public function testPatternPartial() {
    $source = $this->makeSourcePattern();
    $source->partial = 'type-name';
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals($source->partial, $pattern->patternPartial());
  }

  public function _testPatternPartialCode() {
    $rendered = 'RENDERED';
    $source = $this->makeSourcePattern();
    $source->id = 'pattern-id';
    $styleguide = $this->makeStyleguide();
    $styleguide->patternlab->patterns[$source->id] = $source;
    $styleguide->rendered[$source->id] = $rendered;
    $pattern = new Pattern($styleguide, $source);
    $this->assertEquals($rendered, $pattern->patternPartialCode());
  }

  public function testPatternPartialCodeE() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals('', $pattern->patternPartialCodeE());
  }

  public function testPatternSectionSubtype() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertFalse($pattern->patternSectionSubtype());
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