<?php

namespace Labcoat\PatternLab\Styleguide\Files\Patterns;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Patterns\Pattern;

class SourceFileTest extends FileTestCase {

  public function testPath() {
    $dir = 'pattern-id';
    $pattern = new Pattern();
    $pattern->styleguideDirectoryName = $dir;
    $file = new SourceFile($pattern);
    $this->assertPath("patterns/{$dir}/{$dir}.pattern.html", $file->getPath());
  }

  public function testPut() {
    $example = 'This is the pattern example';
    $pattern = new Pattern();
    $pattern->example = $example;
    $file = new SourceFile($pattern);
    $path = $this->makeFile();
    $file->put($path);
    $this->assertEquals($example, file_get_contents($path));
  }

  public function testTime() {
    $time = time();
    $pattern = new Pattern();
    $pattern->time = $time;
    $file = new SourceFile($pattern);
    $this->assertEquals($time, $file->getTime());
  }
}