<?php

namespace Labcoat\Styleguide\Navigation\Folders;

use Labcoat\Mocks\Patterns\Pattern;
use Labcoat\Mocks\Structure\Type as SourceType;

class TypeTest extends \PHPUnit_Framework_TestCase {

  public function testItems() {
    $source = $this->makeSource('one-two');
    $source->patterns[] = new Pattern();
    $type = new Type($source);
    $items = $type->getItems();
    $this->assertEquals(1, count($items));
    $this->assertInstanceOf('Labcoat\\Styleguide\\Navigation\\Pattern', $items[0]);
  }

  protected function makeSource($name) {
    $type = new SourceType();
    $type->name = $name;
    return $type;
  }
}