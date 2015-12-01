<?php

namespace Labcoat\Styleguide\Lineage;

use Labcoat\Mocks\Styleguide\Patterns\Pattern;

class LineagePatternTest extends \PHPUnit_Framework_TestCase {

  public function testLineagePath() {
    $pattern = new Pattern();
    $pattern->lineagePath = 'path.html';
    $lineage = new LineagePattern($pattern);
    $this->assertEquals($pattern->lineagePath, $lineage->getPath());
  }

  public function testLineagePartial() {
    $pattern = new Pattern();
    $pattern->partial = 'partial';
    $lineage = new LineagePattern($pattern);
    $this->assertEquals($pattern->partial, $lineage->getPartial());
  }

  public function testJson() {
    $pattern = new Pattern();
    $pattern->partial = 'partial';
    $pattern->lineagePath = 'path.html';
    $lineage = new LineagePattern($pattern);
    $json = $lineage->jsonSerialize();
    $this->assertEquals($pattern->partial, $json['lineagePattern']);
    $this->assertEquals($pattern->lineagePath, $json['lineagePath']);
  }
}