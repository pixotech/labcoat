<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Styleguide\Files\Html\PageRenderer;
use Labcoat\Mocks\PatternLab\Styleguide\Types\Subtype;

class ViewAllSubtypePageTest extends FileTestCase {

  public function testPath() {
    $name = 'subtype-id';
    $renderer = new PageRenderer();
    $subtype = new Subtype();
    $subtype->styleguideDirectoryName = $name;
    $page = new ViewAllSubtypePage($renderer, $subtype);
    $this->assertPath("patterns/$name/index.html", $page->getPath());
  }

  public function testData() {
    $partial = 'subtype-name';
    $renderer = new PageRenderer();
    $subtype = new Subtype();
    $subtype->partial = $partial;
    $page = new ViewAllSubtypePage($renderer, $subtype);
    $data = $page->getData();
    $this->assertArrayHasKey('patternPartial', $data);
    $this->assertEquals($partial, $data['patternPartial']);
  }
}