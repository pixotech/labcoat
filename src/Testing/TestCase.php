<?php

namespace Labcoat\Testing;

use Labcoat\Patterns\PatternInterface;

abstract class TestCase extends \PHPUnit_Framework_TestCase {

  public static function assertPatternData(PatternInterface $pattern, array $dataClasses, $message = '') {
    self::assertThat($dataClasses, self::hasPatternData($pattern), $message);
  }

  protected static function hasPatternData(PatternInterface $pattern) {
    return new HasPatternDataConstraint($pattern);
  }
}