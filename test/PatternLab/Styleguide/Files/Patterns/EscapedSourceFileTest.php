<?php

namespace Labcoat\PatternLab\Styleguide\Files\Patterns;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\PatternLab\Patterns\Pattern;
use Labcoat\PatternLab\Styleguide\Styleguide;

class EscapedSourceFileTest extends FileTestCase {

  public function testPath() {
    $pattern = new Pattern('name', 'type');
    $styleguide = new Styleguide();
    $dir = $styleguide->getPatternDirectoryName($pattern);
    $file = new EscapedSourceFile($styleguide, $pattern);
    $this->assertPath("patterns/{$dir}/{$dir}.escaped.html", $file->getPath());
  }

  public function testPut() {
    $example = 'This is the <b>pattern example</b>';
    $pattern = new Pattern('name', 'type');
    $pattern->setExample($example);
    $file = new EscapedSourceFile(new Styleguide(), $pattern);
    $path = $this->makeFile();
    $file->put($path);
    $this->assertEquals(htmlentities($example), file_get_contents($path));
  }
}