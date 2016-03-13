<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\PatternLab\Styleguide\Styleguide;
use Labcoat\PatternLab\Patterns\Types\Subtype;
use Labcoat\PatternLab\Patterns\Types\Type;

class ViewAllSubtypePageTest extends FileTestCase {

  public function testPath() {
    $subtype = new Subtype(new Type('type'), 'subtype');
    $styleguide = new Styleguide();
    $page = new ViewAllSubtypePage($styleguide, $subtype);
    $dir = $styleguide->getTypeDirectoryName($subtype);
    $this->assertPath("patterns/$dir/index.html", $page->getPath());
  }

  public function testData() {
    $subtype = new Subtype(new Type('type'), 'subtype');
    $styleguide = new Styleguide();
    $page = new ViewAllSubtypePage($styleguide, $subtype);
    $data = $page->getData();
    $this->assertArrayHasKey('patternPartial', $data);
    $this->assertEquals($subtype->getPartial(), $data['patternPartial']);
  }
}