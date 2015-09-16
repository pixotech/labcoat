<?php

namespace Labcoat\Testing;

use Labcoat\PatternLabInterface;

abstract class TestCase extends \PHPUnit_Framework_TestCase {

  public static function assertPatternData(PatternLabInterface $patternlab, $selector, $className, $message = '') {
    self::assertThat($className, self::hasPatternData($patternlab, $selector), $message);
  }

  protected static function hasPatternData(PatternLabInterface $patternlab, $selector) {
    return new HasPatternDataConstraint($patternlab, $selector);
  }
}