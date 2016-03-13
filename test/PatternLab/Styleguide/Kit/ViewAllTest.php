<?php

namespace Labcoat\PatternLab\Styleguide\Kit;

use Labcoat\PatternLab\Patterns\Pattern;
use Labcoat\PatternLab\Styleguide\Styleguide;

class ViewAllTest extends \PHPUnit_Framework_TestCase {

  public function testPatterns() {
    $patterns = [new Pattern('name', 'type')];
    $viewAll = new ViewAll(new Styleguide(), $patterns);
    $this->assertEquals($patterns, $viewAll->getPatterns());
  }

  public function testPartial() {
    $partial = 'partial';
    $viewAll = new ViewAll(new Styleguide(), [], $partial);
    $this->assertEquals($partial, $viewAll->getPartial());
  }

  public function testString() {
    $viewAll = new ViewAll(new Styleguide(), [], 'partial');
    $content = $viewAll->getContainer() . $viewAll->getScript();
    $this->assertEquals($content, (string)$viewAll);
  }
}