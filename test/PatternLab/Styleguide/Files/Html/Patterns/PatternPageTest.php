<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\Patterns;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Styleguide\Files\Html\PageRenderer;
use Labcoat\Mocks\PatternLab\Patterns\Pattern;

class PatternPageTest extends FileTestCase {

  public function testPattern() {
    $renderer = new PageRenderer();
    $pattern = new Pattern();
    $file = new PatternPage($renderer, $pattern);
    $this->assertSame($pattern, $file->getPattern());
  }

  public function testPath() {
    $dir = 'pattern-id';
    $renderer = new PageRenderer();
    $pattern = new Pattern();
    $pattern->styleguideDirectoryName = $dir;
    $file = new PatternPage($renderer, $pattern);
    $this->assertPath("patterns/{$dir}/{$dir}.html", $file->getPath());
  }

  public function testTime() {
    $time = time();
    $renderer = new PageRenderer();
    $pattern = new Pattern();
    $pattern->time = $time;
    $file = new PatternPage($renderer, $pattern);
    $this->assertEquals($time, $file->getTime());
  }

  public function testContent() {
    $example = '<p>This is the <strong>pattern example</strong></p>';
    $renderer = new PageRenderer();
    $pattern = new Pattern();
    $pattern->example = $example;
    $file = new PatternPage($renderer, $pattern);
    $this->assertEquals($example, $file->getContent());
  }

  public function testDataExtension() {
    $pattern = new Pattern();
    $data = PatternPage::makeData($pattern);
    $this->assertArrayHasKey('patternExtension', $data);
    $this->assertEquals('twig', $data['patternExtension']);
  }

  public function testDataCssEnabled() {
    $pattern = new Pattern();
    $data = PatternPage::makeData($pattern);
    $this->assertArrayHasKey('cssEnabled', $data);
    $this->assertFalse($data['cssEnabled']);
  }

  public function testDataExtraOutput() {
    $pattern = new Pattern();
    $data = PatternPage::makeData($pattern);
    $this->assertArrayHasKey('extraOutput', $data);
    $this->assertEquals([], $data['extraOutput']);
  }

  public function testDataName() {
    $pattern = new Pattern();
    $pattern->label = 'pattern name';
    $data = PatternPage::makeData($pattern);
    $this->assertArrayHasKey('patternName', $data);
    $this->assertEquals($pattern->label, $data['patternName']);
  }

  public function testDataPartial() {
    $pattern = new Pattern();
    $pattern->partial = 'pattern partial';
    $data = PatternPage::makeData($pattern);
    $this->assertArrayHasKey('patternPartial', $data);
    $this->assertEquals($pattern->partial, $data['patternPartial']);
  }

  public function testDataState() {
    $pattern = new Pattern();
    $pattern->state = 'pattern state';
    $data = PatternPage::makeData($pattern);
    $this->assertArrayHasKey('patternState', $data);
    $this->assertEquals($pattern->state, $data['patternState']);
  }

  public function testDataStateExists() {
    $pattern = new Pattern();
    $pattern->state = 'pattern state';
    $data = PatternPage::makeData($pattern);
    $this->assertArrayHasKey('patternStateExists', $data);
    $this->assertTrue($data['patternStateExists']);
  }

  public function testDataStateDoesntExist() {
    $pattern = new Pattern();
    $data = PatternPage::makeData($pattern);
    $this->assertArrayHasKey('patternStateExists', $data);
    $this->assertFalse($data['patternStateExists']);
  }

  public function testDataDescription() {
    $pattern = new Pattern();
    $pattern->description = 'pattern description';
    $data = PatternPage::makeData($pattern);
    $this->assertArrayHasKey('patternDesc', $data);
    $this->assertEquals($pattern->description, $data['patternDesc']);
  }

  public function testDataLineage() {
    $pattern = new Pattern();
    $data = PatternPage::makeData($pattern);
    $this->assertArrayHasKey('lineage', $data);
    $this->assertEquals(PatternPage::makePatternLineage($pattern), $data['lineage']);
  }

  public function testDataReverseLineage() {
    $pattern = new Pattern();
    $data = PatternPage::makeData($pattern);
    $this->assertArrayHasKey('lineageR', $data);
    $this->assertEquals(PatternPage::makeReversePatternLineage($pattern), $data['lineageR']);
  }

  public function testLineagePattern() {
    $pattern = new Pattern();
    $pattern->partial = 'pattern partial';
    $lineage = PatternPage::makeLineage($pattern);
    $this->assertArrayHasKey('lineagePattern', $lineage);
    $this->assertEquals($pattern->partial, $lineage['lineagePattern']);
  }

  public function testLineagePath() {
    $dir = 'pattern-id';
    $pattern = new Pattern();
    $pattern->styleguideDirectoryName = $dir;
    $lineage = PatternPage::makeLineage($pattern);
    $this->assertArrayHasKey('lineagePath', $lineage);
    $this->assertEquals("../../{$dir}/{$dir}.html", $lineage['lineagePath']);
  }
}