<?php

namespace Labcoat\Styleguide\Patterns;

use Labcoat\Mocks\PatternLab;
use Labcoat\Mocks\Patterns\Pattern as SourcePattern;
use Labcoat\Mocks\Styleguide\Styleguide;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testPatternCss() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertNull($pattern->patternCSS());
  }

  public function testPatternCssExists() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertFalse($pattern->patternCSSExists());
  }

  public function testPatternDesc() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertEquals('', $pattern->patternDesc());
  }

  public function testPatternDescAdditions() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertEquals([], $pattern->patternDescAdditions());
  }

  public function testPatternDescExists() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertFalse($pattern->patternDescExists());
  }

  public function testPatternEngineName() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertEquals("Twig", $pattern->patternEngineName());
  }

  public function testPatternExampleAdditions() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertEquals([], $pattern->patternExampleAdditions());
  }

  public function testPatternLineageExists() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertFalse($pattern->patternLineageExists());
  }

  public function testPatternLineageEExists() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertFalse($pattern->patternLineageEExists());
  }

  public function testPatternLineageRExists() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertFalse($pattern->patternLineageRExists());
  }

  public function testPatternLineages() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertEquals([], $pattern->patternLineages());
  }

  public function testPatternLineagesR() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertEquals([], $pattern->patternLineagesR());
  }

  public function testPatternLink() {
    $path = 'type-subtype-name';
    $source = $this->makeSourcePattern();
    $source->name = $path;
    $pattern = new Pattern($source);
    $link = $path . DIRECTORY_SEPARATOR . $path . '.html';
    $this->assertEquals($link, $pattern->patternLink());
  }

  public function testPatternName() {
    $source = $this->makeSourcePattern();
    $source->name = 'pattern-name';
    $pattern = new Pattern($source);
    $this->assertEquals("Pattern Name", $pattern->patternName());
  }

  public function testPatternPartial() {
    $source = $this->makeSourcePattern();
    $source->partial = 'type-name';
    $pattern = new Pattern($source);
    $this->assertEquals($source->partial, $pattern->patternPartial());
  }

  public function testPatternPartialCode() {
    $rendered = 'RENDERED';
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $pattern->setContent($rendered);
    $this->assertEquals($rendered, $pattern->patternPartialCode());
  }

  public function testPatternPartialCodeE() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertEquals('', $pattern->patternPartialCodeE());
  }

  public function testPatternSectionSubtype() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertFalse($pattern->patternSectionSubtype());
  }

  protected function makeSourcePattern() {
    return new SourcePattern();
  }
}