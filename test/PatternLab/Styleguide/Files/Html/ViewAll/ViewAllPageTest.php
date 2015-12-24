<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Styleguide\Styleguide;

class ViewAllPageTest extends FileTestCase {

  public function testContent() {
    $content = 'this is the page content';
    $styleguide = new Styleguide();
    $styleguide->rendered['viewall'] = $content;
    $page = new ViewAllPage($styleguide);
    $this->assertEquals($content, $page->getContent());
  }

  public function testContentPatterns() {
    $styleguide = new Styleguide();
    $page = new ViewAllPage($styleguide);
    $variables = $page->getContentVariables();
    $this->assertArrayHasKey('partials', $variables);
    $this->assertEquals([], $variables['partials']);
  }

  public function testContentPartial() {
    $styleguide = new Styleguide();
    $page = new ViewAllPage($styleguide);
    $variables = $page->getContentVariables();
    $this->assertArrayHasKey('patternPartial', $variables);
    $this->assertEquals('', $variables['patternPartial']);
  }

  public function testPath() {
    $styleguide = new Styleguide();
    $page = new ViewAllPage($styleguide);
    $this->assertPath('styleguide/html/styleguide.html', $page->getPath());
  }

  public function testTime() {
    $styleguide = new Styleguide();
    $page = new ViewAllPage($styleguide);
    $this->assertEquals(null, $page->getTime());
  }
}