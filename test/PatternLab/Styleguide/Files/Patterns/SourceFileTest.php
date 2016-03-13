<?php

namespace Labcoat\PatternLab\Styleguide\Files\Patterns;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\PatternLab\Patterns\Pattern;
use Labcoat\PatternLab\Styleguide\Styleguide;

class SourceFileTest extends FileTestCase {

  public function testPath() {
    $pattern = new Pattern('name', 'type');
    $styleguide = new Styleguide();
    $dir = $styleguide->getPatternDirectoryName($pattern);
    $file = new SourceFile($styleguide, $pattern);
    $this->assertPath("patterns/{$dir}/{$dir}.pattern.html", $file->getPath());
  }

  public function testPut() {
    $example = 'This is the pattern example';
    $pattern = new Pattern('name', 'type');
    $pattern->setExample($example);
    $file = new SourceFile(new Styleguide(), $pattern);
    $path = $this->makeFile();
    $file->put($path);
    $this->assertEquals($example, file_get_contents($path));
  }
}