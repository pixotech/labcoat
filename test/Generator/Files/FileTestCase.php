<?php

namespace Labcoat\Generator\Files;

use Labcoat\Generator\Paths\Path;
use Labcoat\Generator\Paths\PathInterface;
use Labcoat\Mocks\PatternLab\Styleguide\Files\Html\PageRenderer;

abstract class FileTestCase extends \PHPUnit_Framework_TestCase {

  protected $testFiles = [];

  protected static function makePath($path) {
    return ($path instanceof PathInterface) ? $path : new Path($path);
  }

  protected function assertPath($expected, $actual, $message = '') {
    $this->assertEquals($this->makePath($expected), $this->makePath($actual), $message);
  }

  protected function makeFile($prefix = 'test') {
    $file = tempnam(sys_get_temp_dir(), $prefix);
    $this->testFiles[] = $file;
    return $file;
  }

  protected function makeRenderer() {
    return new PageRenderer();
  }

  protected function tearDown() {
    parent::tearDown();
    foreach ($this->testFiles as $file) {
      if (file_exists($file)) unlink($file);
    }
    $this->testFiles = [];
  }
}