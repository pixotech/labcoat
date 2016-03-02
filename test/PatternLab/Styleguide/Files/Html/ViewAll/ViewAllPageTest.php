<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Files\FileTestCase;

class ViewAllPageTest extends FileTestCase {

  public function testPath() {
    $page = new ViewAllPage($this->makeRenderer());
    $this->assertPath('styleguide/html/styleguide.html', $page->getPath());
  }
}