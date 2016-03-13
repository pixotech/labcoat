<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript;

use Labcoat\Generator\Files\FileTestCase;

class AnnotationsFileTest extends FileTestCase {

  public function testPath() {
    $file = new AnnotationsFile();
    $this->assertPath('annotations/annotations.js', $file->getPath());
  }
}