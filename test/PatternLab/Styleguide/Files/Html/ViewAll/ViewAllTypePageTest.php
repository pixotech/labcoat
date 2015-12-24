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
    $name = 'type-name';
    $styleguide = new Styleguide();
    $type = new Type();
    $type->name = $name;
    $page = new ViewAllTypePage($styleguide, $type);
    $data = $page->getData();
    $this->assertArrayHasKey('patternPartial', $data);
    $this->assertEquals("viewall-{$name}-all", $data['patternPartial']);
  }
}