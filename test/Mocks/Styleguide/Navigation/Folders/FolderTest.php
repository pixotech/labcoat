<?php

namespace Labcoat\Mocks\Styleguide\Navigation\Folders;

use Labcoat\Mocks\Structure\Folder as Source;

class FolderTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $name = 'folder';
    $folder = new Folder($this->makeSource($name));
    $this->assertEquals($name, $folder->getName());
  }

  public function testNameIncludesOrdering() {
    $name = '01-folder';
    $folder = new Folder($this->makeSource($name));
    $this->assertEquals($name, $folder->getName());
  }

  public function testLowercaseName() {
    $folder = new Folder($this->makeSource('one-two'));
    $this->assertEquals('one two', $folder->getLowercaseName());
  }

  public function testUppercaseName() {
    $folder = new Folder($this->makeSource('one-two'));
    $this->assertEquals('One Two', $folder->getUppercaseName());
  }

  public function testItems() {
    $folder = new Folder($this->makeSource('one-two'));
    $this->assertEquals([], $folder->getItems());
  }

  public function makeSource($name) {
    return new Source($name);
  }
}