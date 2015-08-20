<?php

namespace Labcoat\Data;

use Labcoat\Patterns\PatternInterface;

class HasPropertiesConstraint extends \PHPUnit_Framework_Constraint {

  protected $propertyNames = [];

  public function __construct(PatternInterface $pattern, $variable) {
    parent::__construct();
    $this->propertyNames = $this->getPatternVariableNames($pattern, $variable);
  }

  public function toString() {
    return 'contains the required pattern variables';
  }

  /**
   * @see http://twig.sensiolabs.org/doc/templates.html
   */
  public function matches($className) {
    $reflection = new ReflectionClass($className);
    foreach ($this->propertyNames as $name) {
      if ($reflection->hasPublicProperty($name)) continue;
      if ($reflection->hasPublicMethod($name)) continue;
      if ($reflection->hasPublicGetterMethod($name)) continue;
      if ($reflection->hasPublicTestMethod($name)) continue;
      return false;
    }
    return true;
  }

  protected function getPatternVariableNames(PatternInterface $pattern, $variable) {
    if (!$pattern->hasData()) {
      throw new \Exception("Pattern has no data");
    }
    $data = $pattern->getData();
    if (!array_key_exists($variable, $data)) {
      throw new \Exception("Variable not found: $variable");
    }
    return array_keys($data[$variable]);
  }
}