<?php

namespace Labcoat\Patterns;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testShorthand() {
    $pattern = new Pattern("00-atoms/03-images/02-landscape-16x9.twig", $this->makeFile());
    $this->assertEquals("atoms-landscape-16x9", $pattern->getShorthand());
  }

  public function testMatchTemplate() {
    $template = "00-atoms/00-global/05-test.twig";
    $pattern = new Pattern($template, $this->makeFile());
    $this->assertTrue($pattern->matchesTemplate($template));
  }

  public function testMatchShorthand() {
    $shorthand = "atoms-test";
    $template = "00-atoms/00-global/05-test.twig";
    $pattern = new Pattern($template, $this->makeFile());
    $this->assertTrue($pattern->matchesShorthand($shorthand));
  }

  public function testMatchPartialShorthand() {
    $shorthand = "atoms-test-wit";
    $template = "00-atoms/00-global/04-test-with-picture.twig";
    $pattern = new Pattern($template, $this->makeFile());
    $this->assertTrue($pattern->matchesPartialShorthand($shorthand));
  }

  public function testMatchPartialTemplate() {
    $partial = "00-atoms/00-global/06-test";
    $template = "00-atoms/00-global/06-test.twig";
    $pattern = new Pattern($template, $this->makeFile());
    $this->assertTrue($pattern->matchesPartialTemplate($partial));
  }

  public function testDoesntMatchPartialTemplateWithoutDigits() {
    $partial = "atoms/global/06-test";
    $template = "00-atoms/00-global/06-test.twig";
    $pattern = new Pattern($template, $this->makeFile());
    $this->assertFalse($pattern->matchesPartialTemplate($partial));
  }

  protected function makeFile() {
    return new \SplFileInfo(__FILE__);
  }
}