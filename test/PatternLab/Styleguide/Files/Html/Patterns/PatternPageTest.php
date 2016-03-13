<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\Patterns;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Styleguide\Styleguide;
use Labcoat\Mocks\PatternLab\Patterns\Pattern;

class PatternPageTest extends FileTestCase {

  public function testPattern() {
    $styleguide = new Styleguide();
    $pattern = new Pattern();
    $file = new PatternPage($styleguide, $pattern);
    $this->assertSame($pattern, $file->getPattern());
  }

  public function testPath() {
    $dir = 'pattern-id';
    $styleguide = new Styleguide();
    $pattern = new Pattern();
    $pattern->styleguideDirectoryName = $dir;
    $file = new PatternPage($styleguide, $pattern);
    $this->assertPath("patterns/{$dir}/{$dir}.html", $file->getPath());
  }

  public function testTime() {
    $time = time();
    $styleguide = new Styleguide();
    $pattern = new Pattern();
    $pattern->time = $time;
    $file = new PatternPage($styleguide, $pattern);
    $this->assertEquals($time, $file->getTime());
  }

  public function testContent() {
    $example = '<p>This is the <strong>pattern example</strong></p>';
    $styleguide = new Styleguide();
    $pattern = new Pattern();
    $pattern->example = $example;
    $file = new PatternPage($styleguide, $pattern);
    $this->assertEquals($example, $file->getContent());
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