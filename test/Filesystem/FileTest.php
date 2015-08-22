<?php

namespace Labcoat\Filesystem;

use Labcoat\Mocks\PatternLab;

class FilesystemTest extends \PHPUnit_Framework_TestCase {

  public function testDirectoryNames() {
    $file = $this->makeFile("path/to/file");
    $this->assertEquals(['path', 'to'], $file->getDirectoryNames());
  }

  public function testHasDirectoryName() {
    $file = $this->makeFile("path/to/file");
    $this->assertTrue($file->hasDirectoryName('path'));
  }

  public function testDoesntHasDirectoryName() {
    $file = $this->makeFile("path/to/file");
    $this->assertFalse($file->hasDirectoryName('file'));
  }

  public function testHasDirectoryNameFromArray() {
    $file = $this->makeFile("path/to/file");
    $this->assertTrue($file->hasDirectoryName(['path', 'file']));
  }

  public function testDoesntHasDirectoryNameFromArray() {
    $file = $this->makeFile("path/to/file");
    $this->assertFalse($file->hasDirectoryName(['directory', 'file']));
  }

  public function testGetExtension() {
    $file = $this->makeFile("path/to/file.ext");
    $this->assertEquals('ext', $file->getExtension());
  }

  public function testGetExtensionWithDot() {
    $file = $this->makeFile("path/to/file.multiple.extensions");
    $this->assertEquals('multiple.extensions', $file->getExtension());
  }

  public function testNoExtension() {
    $file = $this->makeFile("path/to/file");
    $this->assertNull($file->getExtension());
  }

  public function testFullPath() {
    $file = $this->makeFile("path/to/file");
    $this->assertEquals("path/to/file", $file->getFullPath());
  }

  public function testFullPathWithRoot() {
    $patternlab = $this->makePatternLab();
    $root = new Directory($patternlab, "path/to/directory");
    $file = new File($patternlab, "path/to/file", $root);
    $this->assertEquals("path/to/directory/path/to/file", $file->getFullPath());
  }

  public function testGetPathWithoutExtension() {
    $file = $this->makeFile("path/to/file.extension");
    $this->assertEquals("path/to/file", $file->getPathWithoutExtension());
  }

  public function testGetPathWithoutExtensionWhenPathHasNoExtension() {
    $file = $this->makeFile("path/to/file");
    $this->assertEquals("path/to/file", $file->getPathWithoutExtension());
  }

  public function testIsIgnoredExtension() {
    $patternlab = $this->makePatternLab();
    $patternlab->ignoredExtensions[] = 'scss';
    $file = new File($patternlab, "ignore/this/file.scss");
    $this->assertTrue($file->hasIgnoredExtension());
  }

  protected function makeFile($path) {
    return new File($this->makePatternLab(), $path);
  }

  protected function makePatternLab() {
    return new PatternLab();
  }
}