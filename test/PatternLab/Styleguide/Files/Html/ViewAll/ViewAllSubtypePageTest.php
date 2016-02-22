<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Styleguide\Patterns\Types\Subtype;
use Labcoat\Mocks\PatternLab\Styleguide\Styleguide;

class ViewAllSubtypePageTest extends FileTestCase {

  public function testPath() {
    $id = 'subtype-id';
    $styleguide = new Styleguide();
    $subtype = new Subtype();
    $subtype->id = $id;
    $page = new ViewAllSubtypePage($styleguide, $subtype);
    $this->assertPath("patterns/$id/index.html", $page->getPath());
  }

  public function testData() {
    $partial = 'subtype-name';
    $styleguide = new Styleguide();
    $subtype = new Subtype();
    $subtype->partial = $partial;
    $page = new ViewAllSubtypePage($styleguide, $subtype);
    $data = $page->getData();
    $this->assertArrayHasKey('patternPartial', $data);
    $this->assertEquals($partial, $data['patternPartial']);
  }
}