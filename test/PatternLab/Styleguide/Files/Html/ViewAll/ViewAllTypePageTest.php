<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Styleguide\Files\Html\PageRenderer;
use Labcoat\Mocks\PatternLab\Styleguide\Types\Type;

class ViewAllTypePageTest extends FileTestCase {

  public function testPath() {
    $name = 'type-id';
    $renderer = new PageRenderer();
    $type = new Type();
    $type->name = $name;
    $page = new ViewAllTypePage($renderer, $type);
    $this->assertPath("patterns/$name/index.html", $page->getPath());
  }

  public function testData() {
    $partial = 'type-name';
    $renderer = new PageRenderer();
    $type = new Type();
    $type->partial = $partial;
    $page = new ViewAllTypePage($renderer, $type);
    $data = $page->getData();
    $this->assertArrayHasKey('patternPartial', $data);
    $this->assertEquals($partial, $data['patternPartial']);
  }
}