<?php

namespace Labcoat\Mocks\PatternLab\Patterns\Types;

class FolderTest extends \PHPUnit_Framework_TestCase {

  public function testName() {
    $name = 'folder';
    $folder = new Folder($name);
    $this->assertEquals($name, $folder->getName());
  }

  public function testPatterns() {
    $folder = new Folder('folder');
    $this->assertEquals([], $folder->getPatterns());
  }
}