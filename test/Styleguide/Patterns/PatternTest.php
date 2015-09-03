<?php

namespace Labcoat\Styleguide\Patterns;

use Labcoat\Mocks\Patterns\Pattern as SourcePattern;
use Labcoat\Mocks\Patterns\PseudoPattern;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testId() {
    $source = $this->makeSourcePattern();
    $source->id = 'id';
    $pattern = new Pattern($source);
    $this->assertEquals($source->id, $pattern->getId());
  }

  public function testName() {
    $source = $this->makeSourcePattern();
    $source->name = 'name';
    $pattern = new Pattern($source);
    $this->assertEquals($source->name, $pattern->getName());
  }

  public function testFile() {
    $source = $this->makeSourcePattern();
    $source->file = 'file';
    $pattern = new Pattern($source);
    $this->assertEquals($source->file, $pattern->getFile());
  }

  public function testParentId() {
    $source = $this->makePseudoPattern();
    $source->pattern->id = 'parent id';
    $pattern = new Pattern($source);
    $this->assertEquals($source->pattern->id, $pattern->getParentId());
  }

  public function testPath() {
    $source = $this->makeSourcePattern();
    $source->path = 'path';
    $pattern = new Pattern($source);
    $this->assertEquals($source->path, $pattern->getPath());
  }

  public function testTemplate() {
    $source = $this->makeSourcePattern();
    $source->template = 'template';
    $pattern = new Pattern($source);
    $this->assertEquals($source->template, $pattern->getTemplate());
  }

  public function testVariantName() {
    $source = $this->makePseudoPattern();
    $source->variantName = 'variant';
    $pattern = new Pattern($source);
    $this->assertEquals($source->variantName, $pattern->getVariantName());
  }

  public function testIsPseudo() {
    $source = $this->makePseudoPattern();
    $pattern = new Pattern($source);
    $this->assertTrue($pattern->isPseudo());
  }

  public function testIsNotPseudo() {
    $source = $this->makeSourcePattern();
    $pattern = new Pattern($source);
    $this->assertFalse($pattern->isPseudo());
  }

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

  protected function makePseudoPattern() {
    return new PseudoPattern();
  }

  protected function makeSourcePattern() {
    return new SourcePattern();
  }
}