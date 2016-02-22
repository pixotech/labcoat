<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Files\FileTestCase;
use Labcoat\Mocks\PatternLab\Styleguide\Files\Html\PageRenderer;

class ViewAllPageTest extends FileTestCase {

  public function testContent() {
    $content = 'this is the page content';
    $renderer = new PageRenderer();
    $styleguide->rendered['viewall'] = $content;
    $page = new ViewAllPage($renderer);
    $this->assertEquals($content, $page->getContent());
  }

  public function testContentPatterns() {
    $renderer = new PageRenderer();
    $page = new ViewAllPage($renderer);
    $variables = $page->getContentVariables();
    $this->assertArrayHasKey('partials', $variables);
    $this->assertEquals([], $variables['partials']);
  }

  public function testContentPartial() {
    $renderer = new PageRenderer();
    $page = new ViewAllPage($renderer);
    $variables = $page->getContentVariables();
    $this->assertArrayHasKey('patternPartial', $variables);
    $this->assertEquals('', $variables['patternPartial']);
  }

  public function testPath() {
    $renderer = new PageRenderer();
    $page = new ViewAllPage($renderer);
    $this->assertPath('styleguide/html/styleguide.html', $page->getPath());
  }

  public function testTime() {
    $renderer = new PageRenderer();
    $page = new ViewAllPage($renderer);
    $this->assertEquals(null, $page->getTime());
  }
}