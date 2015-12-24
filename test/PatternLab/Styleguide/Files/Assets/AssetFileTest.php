<?php

namespace Labcoat\PatternLab\Styleguide\Files\Assets;

use Labcoat\Generator\Files\FileTestCase;

class AssetFileTest extends FileTestCase {

  public function testTime() {
    $file = $this->makeFile();
    $path = 'path/to/destination';
    $asset = new AssetFile($path, $file);
    $this->assertEquals(filemtime($file), $asset->getTime());
  }

  public function testPath() {
    $file = 'path/to/source';
    $path = 'path/to/destination';
    $asset = new AssetFile($path, $file);
    $this->assertPath('styleguide/' . $path, $asset->getPath());
  }

  public function testHtmlPath() {
    $file = 'path/to/source';
    $path = 'html/filename';
    $asset = new AssetFile($path, $file);
    $this->assertPath('filename', $asset->getPath());
  }

  public function testCustomCssPath() {
    $file = 'path/to/source';
    $path = 'css/custom/filename';
    $asset = new AssetFile($path, $file);
    $this->assertPath('styleguide/css/filename', $asset->getPath());
  }

  public function testPatternLabCssPath() {
    $file = 'path/to/source';
    $path = 'css/patternlab/filename';
    $asset = new AssetFile($path, $file);
    $this->assertPath('styleguide/css/filename', $asset->getPath());
  }
}