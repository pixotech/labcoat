<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html;

class PageRendererTest extends \PHPUnit_Framework_TestCase {

  public function testRender() {
    $cacheBuster = time();
    $header = "HEADER";
    $footer = "FOOTER";
    $content = "CONTENT";
    $renderer = new PageRenderer($header, $footer, $cacheBuster);
    $rendered = $renderer->renderPage($content);
    $this->assertEquals($header . $content . $footer, $rendered);
  }
}