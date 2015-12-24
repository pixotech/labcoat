<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\Patterns;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Patterns\Pattern;
use Labcoat\Mocks\PatternLab\Styleguide\Styleguide;

class PatternPageTest extends FileTestCase {

  public function testPath() {
    $id = 'pattern-id';
    $styleguide = new Styleguide();
    $pattern = new Pattern();
    $pattern->id = $id;
    $file = new PatternPage($styleguide, $pattern);
    $this->assertPath("patterns/{$id}/{$id}.html", $file->getPath());
  }

  public function testTime() {
    $time = time();
    $styleguide = new Styleguide();
    $pattern = new Pattern();
    $pattern->time = $time;
    $file = new PatternPage($styleguide, $pattern);
    $this->assertEquals($time, $file->getTime());
  }
}