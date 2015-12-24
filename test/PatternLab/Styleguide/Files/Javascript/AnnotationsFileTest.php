<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript;

use Labcoat\Generator\Files\FileTestCase;

class AnnotationsFileTest extends FileTestCase {

  public function testTime() {
    $path = $this->makeFile();
    $file = new AnnotationsFile($path);
    $this->assertEquals(filemtime($path), $file->getTime());
  }

  public function testPath() {
    $path = $this->makeFile();
    $file = new AnnotationsFile($path);
    $this->assertPath('annotations/annotations.js', $file->getPath());
  }
}