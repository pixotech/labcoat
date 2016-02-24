<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Styleguide\Files\Html\PageRenderer;

class ViewAllPageTest extends FileTestCase {

  public function testPath() {
    $renderer = new PageRenderer();
    $page = new ViewAllPage($renderer);
    $this->assertPath('styleguide/html/styleguide.html', $page->getPath());
  }

  public function testTime() {
    $renderer = new PageRenderer();
    $page = new ViewAllPage($renderer);
    $this->assertEquals(null, $page->getTime());
  }
}