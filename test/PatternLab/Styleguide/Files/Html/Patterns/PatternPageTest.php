<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\Patterns;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\PatternLab\Styleguide\Styleguide;
use Labcoat\PatternLab\Patterns\Pattern;

class PatternPageTest extends FileTestCase {

  public function testPattern() {
    $styleguide = new Styleguide();
    $pattern = new Pattern('name', 'type');
    $file = new PatternPage($styleguide, $pattern);
    $this->assertSame($pattern, $file->getPattern());
  }

  public function testPath() {
    $styleguide = new Styleguide();
    $pattern = new Pattern('name', 'type');
    $dir = $styleguide->getPatternDirectoryName($pattern);
    $file = new PatternPage($styleguide, $pattern);
    $this->assertPath("patterns/{$dir}/{$dir}.html", $file->getPath());
  }

  public function testContent() {
    $example = '<p>This is the <strong>pattern example</strong></p>';
    $styleguide = new Styleguide();
    $pattern = new Pattern('name', 'type');
    $pattern->setExample($example);
    $file = new PatternPage($styleguide, $pattern);
    $this->assertEquals($example, $file->getContent());
  }
}