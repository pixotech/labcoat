<?php

namespace Labcoat\Styleguide\Navigation\Folders;

use Labcoat\Mocks\Structure\Subtype as SourceSubtype;
use Labcoat\Mocks\Structure\Type;

class SubtypeTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $source = $this->makeSource('type', 'one');
    $subtype = new Subtype($source);
    $this->assertEquals('one', $subtype->getName());
  }

  protected function makeSource($typeName, $name) {
    $type = new Type();
    $type->name = $typeName;
    $subtype = new SourceSubtype();
    $subtype->type = $type;
    $subtype->name = $name;
    return $subtype;
  }
}