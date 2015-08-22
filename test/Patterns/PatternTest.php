<?php

namespace Labcoat\Patterns;

use Labcoat\Filesystem\File;
use Labcoat\Mocks\PatternLab;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testShorthand() {
    $pattern = new Pattern($this->makeFile("00-atoms/03-images/02-landscape-16x9.twig"));
    $this->assertEquals("atoms-landscape-16x9", $pattern->getShorthand());
  }

  public function testPath() {
    $template = "00-atoms/00-global/05-test.twig";
    $pattern = new Pattern($this->makeFile($template));
    $this->assertEquals("atoms/global/test", $pattern->getPath());
  }

  protected function makeFile($template) {
    $patternlab = new PatternLab();
    return new File($patternlab, $template);
  }
}