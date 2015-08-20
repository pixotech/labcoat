<?php

namespace Pixo\PatternLab\Data;

use Pixo\PatternLab\Patterns\PatternInterface;

abstract class TestCase extends \PHPUnit_Framework_TestCase {

  public static function assertHasProperties($className, PatternInterface $pattern, $variable, $message = '') {
    self::assertThat($className, self::hasProperties($pattern, $variable), $message);
  }

  protected static function hasProperties(PatternInterface $pattern, $variable) {
    return new HasPropertiesConstraint($pattern, $variable);
  }
}