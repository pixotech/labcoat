<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Patterns\Types\Type;
use Labcoat\Mocks\PatternLab\Styleguide\Styleguide;

class ViewAllTypePageTest extends FileTestCase {

  public function testPath() {
    $id = 'type-id';
    $styleguide = new Styleguide();
    $type = new Type();
    $type->id = $id;
    $page = new ViewAllTypePage($styleguide, $type);
    $this->assertPath("patterns/$id/index.html", $page->getPath());
  }

  public function testData() {
    $partial = 'type-name';
    $styleguide = new Styleguide();
    $type = new Type();
    $type->partial = $partial;
    $page = new ViewAllTypePage($styleguide, $type);
    $data = $page->getData();
    $this->assertArrayHasKey('patternPartial', $data);
    $this->assertEquals($partial, $data['patternPartial']);
  }
}