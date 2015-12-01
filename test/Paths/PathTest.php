<?php

namespace Labcoat\Paths;

class PathTest extends \PHPUnit_Framework_TestCase {

  public function testPathString() {
    $str = 'path';
    $path = new Path($str);
    $this->assertEquals($str, (string)$path);
  }
}