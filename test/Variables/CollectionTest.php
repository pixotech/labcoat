<?php

namespace Labcoat\Variables;

class CollectionTest extends \PHPUnit_Framework_TestCase {

  public function testGet() {
    $source = ['one' => 1];
    $collection = new Collection($source);
    $this->assertEquals($source['one'], $collection->get('one'));
  }

  public function testGetNested() {
    $source = ['one' => ['two' => 2]];
    $collection = new Collection($source);
    $this->assertEquals($source['one']['two'], $collection->get('one.two'));
  }
}