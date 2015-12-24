<?php

namespace Labcoat\PatternLab\Styleguide\Files\Text;

use Labcoat\Generator\Paths\Path;

class LatestChangeFileTest extends \PHPUnit_Framework_TestCase {

  protected $testFile;

  protected function tearDown() {
    parent::tearDown();
    if (file_exists($this->testFile)) unlink($this->testFile);
  }

  public function testTime() {
    $time = time();
    $file = new LatestChangeFile($time);
    $this->assertEquals($time, $file->getTime());
  }

  public function testPath() {
    $file = new LatestChangeFile(time());
    $this->assertEquals(new Path('latest-change.txt'), $file->getPath());
  }

  public function testFile() {
    $time = time();
    $file = new LatestChangeFile($time);
    $path = $this->getFilePath();
    $file->put($path);
    $this->assertEquals($time, file_get_contents($path));
  }

  protected function getFilePath() {
    return $this->testFile = tempnam(sys_get_temp_dir(), 'test');
  }
}