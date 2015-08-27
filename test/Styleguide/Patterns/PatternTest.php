<?php

namespace Labcoat\Styleguide\Patterns;

use Labcoat\Mocks\PatternLab;
use Labcoat\Mocks\Patterns\Pattern as SourcePattern;
use Labcoat\Mocks\Styleguide\Styleguide;

class PatternTest extends \PHPUnit_Framework_TestCase {

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
    $path = 'type-subtype-name';
    $source = $this->makeSourcePattern();
    $source->styleguidePathName = $path;
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $link = $path . DIRECTORY_SEPARATOR . $path . '.html';
    $this->assertEquals($link, $pattern->patternLink());
  }

  public function testPatternName() {
    $source = $this->makeSourcePattern();
    $source->displayName = 'Pattern Name';
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals($source->displayName, $pattern->patternName());
  }

  public function testPatternPartial() {
    $source = $this->makeSourcePattern();
    $source->partial = 'type-name';
    $pattern = new Pattern($this->makeStyleguide(), $source);
    $this->assertEquals($source->partial, $pattern->patternPartial());
  }

  public function testPatternPartialCode() {
    $rendered = '<p>Rendered pattern</p>';
    $styleguide = $this->makeStyleguide();
    $styleguide->patternlab = new PatternLab();
    $styleguide->patternlab->render = $rendered;
    $source = $this->makeSourcePattern();
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

  protected function makeSourcePattern() {
    return new SourcePattern();
  }

  protected function makeStyleguide() {
    return new Styleguide();
  }
}