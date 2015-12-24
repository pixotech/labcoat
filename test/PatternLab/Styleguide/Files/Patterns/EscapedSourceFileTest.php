<?php

namespace Labcoat\PatternLab\Styleguide\Files\Patterns;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Patterns\Pattern;

class EscapedSourceFileTest extends FileTestCase {

  public function testPath() {
    $id = 'pattern-id';
    $pattern = new Pattern();
    $pattern->id = $id;
    $file = new EscapedSourceFile($pattern);
    $this->assertPath("patterns/{$id}/{$id}.escaped.html", $file->getPath());
  }

  public function testPut() {
    $example = 'This is the <b>pattern example</b>';
    $pattern = new Pattern();
    $pattern->example = $example;
    $file = new EscapedSourceFile($pattern);
    $path = $this->makeFile();
    $file->put($path);
    $this->assertEquals(htmlentities($example), file_get_contents($path));
  }

  public function testTime() {
    $time = time();
    $pattern = new Pattern();
    $pattern->time = $time;
    $file = new EscapedSourceFile($pattern);
    $this->assertEquals($time, $file->getTime());
  }
}