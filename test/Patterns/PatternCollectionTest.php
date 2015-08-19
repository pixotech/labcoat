<?php

namespace Pixo\PatternLab\Patterns;

class PatternCollectionTest extends \PHPUnit_Framework_TestCase {

  public static $testPaths = [
    '00-atoms/00-global/04-test-with-picture.twig',
    '00-atoms/00-global/05-test.twig',
    '00-atoms/00-global/06-test.twig',
    '00-atoms/00-global/test.twig',
  ];

  public function testGetPatternByShorthand() {
    $collection = $this->makeCollection();
    $pattern = $collection->get('atoms-test-with-picture');
    $this->assertEquals('00-atoms/00-global/04-test-with-picture.twig', $pattern->getTemplate());
  }

  public function testGetPatternByPartialShorthand() {
    $collection = $this->makeCollection();
    $pattern = $collection->get('atoms-test-wit');
    $this->assertEquals('00-atoms/00-global/04-test-with-picture.twig', $pattern->getTemplate());
  }

  public function testPreferExactShorthandToPartialShorthand() {
    $collection = $this->makeCollection();
    $pattern = $collection->get('atoms-test');
    $this->assertEquals('00-atoms/00-global/05-test.twig', $pattern->getTemplate());
  }

  public function testGetPatternByPartialTemplate() {
    $collection = $this->makeCollection();
    $pattern = $collection->get('00-atoms/00-global/06-test');
    $this->assertEquals('00-atoms/00-global/06-test.twig', $pattern->getTemplate());
  }

  /**
   * @expectedException \OutOfBoundsException
   */
  public function testCantGetPatternByPartialTemplateWithoutDigits() {
    $collection = $this->makeCollection();
    $collection->get('atoms/global/06-test');
  }

  protected function makeCollection() {
    $collection = new PatternCollection();
    foreach (self::$testPaths as $path) {
      $collection->add($this->makePattern($path));
    }
    return $collection;
  }

  protected function makePattern($template) {
    return new Pattern($template, new \SplFileInfo(__FILE__));
  }
}