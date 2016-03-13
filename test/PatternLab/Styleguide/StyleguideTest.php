<?php

namespace Labcoat\PatternLab\Styleguide;

class StyleguideTest extends \PHPUnit_Framework_TestCase {

  public function testCacheBuster() {
    $string = 'cachebusterstring';
    $styleguide = new Styleguide();
    $styleguide->setCacheBuster($string);
    $this->assertEquals($string, $styleguide->getCacheBuster());
  }

  public function testHiddenControls() {
    $controls = ['one', 'two', 'three'];
    $styleguide = new Styleguide();
    $styleguide->setHiddenControls($controls);
    $this->assertEquals($controls, $styleguide->getHiddenControls());
  }

  public function testMinimumWidth() {
    $width = 100;
    $styleguide = new Styleguide();
    $styleguide->setMinimumWidth($width);
    $this->assertEquals($width, $styleguide->getMinimumWidth());
  }

  public function testMaximumWidth() {
    $width = 1000;
    $styleguide = new Styleguide();
    $styleguide->setMaximumWidth($width);
    $this->assertEquals($width, $styleguide->getMaximumWidth());
  }

  public function testBreakpoints() {
    $breakpoints = [100, 200, 300];
    $styleguide = new Styleguide();
    $styleguide->setBreakpoints($breakpoints);
    $this->assertEquals($breakpoints, $styleguide->getBreakpoints());
  }
}