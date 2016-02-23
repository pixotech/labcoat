<?php

namespace Labcoat\PatternLab;

class PatternTest extends \PHPUnit_Framework_TestCase {

  public function testMakeFromFile() {
    $dir = __DIR__;
    $path = 'one/two/three';
    $extension = 'twig';
    $pattern = Pattern::makeFromFile($dir, $path, $extension);
    $this->assertEquals($pattern->getFile(), implode(DIRECTORY_SEPARATOR, [$dir, $path, $extension]));
  }

  public function testNameFromFile() {
    $pattern = Pattern::makeFromFile(__DIR__, 'one/two/three', 'twig');
    $this->assertEquals($pattern->getName(), 'three');
  }

  public function testLabelFromFile() {
    $pattern = Pattern::makeFromFile(__DIR__, 'one/two/three', 'twig');
    $this->assertEquals($pattern->getLabel(), 'Three');
  }

  public function testMultiWordLabelFromFile() {
    $pattern = Pattern::makeFromFile(__DIR__, 'one/two/three-and-four', 'twig');
    $this->assertEquals($pattern->getLabel(), 'Three And Four');
  }

  public function testTypeFromFile() {
    $pattern = Pattern::makeFromFile(__DIR__, 'one/two/three', 'twig');
    $this->assertEquals($pattern->getType(), 'one');
  }

  public function testNoTypeFromFile() {
    $pattern = Pattern::makeFromFile(__DIR__, 'one', 'twig');
    $this->assertFalse($pattern->hasType());
  }

  public function testSubtypeFromFile() {
    $pattern = Pattern::makeFromFile(__DIR__, 'one/two/three', 'twig');
    $this->assertEquals($pattern->getSubtype(), 'two');
  }

  public function testNoSubtypeFromFile() {
    $pattern = Pattern::makeFromFile(__DIR__, 'one/two', 'twig');
    $this->assertFalse($pattern->hasSubtype());
  }
}