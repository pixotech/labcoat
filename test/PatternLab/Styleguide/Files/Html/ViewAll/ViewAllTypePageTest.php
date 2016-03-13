<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Styleguide\Styleguide;
use Labcoat\Mocks\PatternLab\Styleguide\Types\Type;

class ViewAllTypePageTest extends FileTestCase {

  public function testPath() {
    $name = 'type-id';
    $type = new Type();
    $type->name = $name;
    $styleguide = new Styleguide();
    $page = new ViewAllTypePage($styleguide, $type);
    $this->assertPath("patterns/$name/index.html", $page->getPath());
  }

  public function testData() {
    $partial = 'type-name';
    $type = new Type();
    $type->partial = $partial;
    $styleguide = new Styleguide();
    $page = new ViewAllTypePage($styleguide, $type);
    $data = $page->getData();
    $this->assertArrayHasKey('patternPartial', $data);
    $this->assertEquals($partial, $data['patternPartial']);
  }
}