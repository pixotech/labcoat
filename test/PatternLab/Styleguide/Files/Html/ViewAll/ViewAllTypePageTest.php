<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\PatternLab\Styleguide\Styleguide;
use Labcoat\PatternLab\Styleguide\Types\Type;

class ViewAllTypePageTest extends FileTestCase {

  public function testPath() {
    $type = new Type('type');
    $styleguide = new Styleguide();
    $page = new ViewAllTypePage($styleguide, $type);
    $dir = $styleguide->getTypeDirectoryName($type);
    $this->assertPath("patterns/$dir/index.html", $page->getPath());
  }

  public function testData() {
    $type = new Type('type');
    $page = new ViewAllTypePage(new Styleguide(), $type);
    $data = $page->getData();
    $this->assertArrayHasKey('patternPartial', $data);
    $this->assertEquals($type->getPartial(), $data['patternPartial']);
  }
}