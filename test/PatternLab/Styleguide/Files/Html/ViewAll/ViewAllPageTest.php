<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\PatternLab\Styleguide\Styleguide;

class ViewAllPageTest extends FileTestCase {

  public function testPath() {
    $styleguide = new Styleguide();
    $page = new ViewAllPage($styleguide);
    $this->assertPath('styleguide/html/styleguide.html', $page->getPath());
  }
}