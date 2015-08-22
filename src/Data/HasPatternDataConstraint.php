<?php

namespace Labcoat\Data;

use Labcoat\Patterns\PatternInterface;

class HasPatternDataConstraint extends \PHPUnit_Framework_Constraint {

  protected $pattern;

  public function __construct(PatternInterface $pattern) {
    parent::__construct();
    $this->pattern = $pattern;
  }

  public function toString() {
    return 'contain the required pattern variables';
  }

  public function matches(array $dataClasses) {
    foreach ($dataClasses as $selector => $dataClassName) {
      $reflection = new ReflectionClass($dataClassName);
      foreach ($this->getPatternVariableNames($selector) as $name) {
        if (!$reflection->hasTemplateVariable($name)) return false;
      }
    }
    return true;
  }

  protected function additionalFailureDescription($dataClasses) {
    $description = "\n";
    $description .= sprintf("Pattern: %s\n", $this->pattern->getPath());
    $description .= sprintf("Template: %s\n", $this->pattern->getFile());
    foreach ($dataClasses as $selector => $dataClassName) {
      $reflection = new ReflectionClass($dataClassName);
      $description .= "\n";
      foreach ($this->getPatternVariableNames($selector) as $name) {
        $description .= sprintf("%s.%s\n", $selector, $name);
        $found = false;
        $location = null;
        $methodName = null;
        if ($reflection->hasPublicProperty($name)) {
          $found = true;
          $location = $this->makePropertySignature($reflection, $name);
        }
        elseif ($reflection->hasPublicMethod($name)) {
          $found = true;
          $location = $this->makeMethodSignature($reflection, $name);
        }
        elseif ($reflection->hasPublicGetterMethod($name)) {
          $found = true;
          $location = $this->makeMethodSignature($reflection, $reflection->getGetterMethodName($name));
        }
        elseif ($reflection->hasPublicTestMethod($name)) {
          $found = true;
          $location = $this->makeMethodSignature($reflection, $reflection->getTestMethodName($name));
        }
        if ($found) $description .= sprintf("  FOUND: %s\n", $location);
        else $description .= "  NOT FOUND\n";
      }
    }
    return $description;
  }

  protected function failureDescription($dataClasses) {
    return "the data classes " . $this->toString();
  }

  protected function getPatternVariable($selector) {
    $data = $this->pattern->getData()[$selector];
    if (is_null($data)) throw new \Exception("Unknown variable: $selector");
    if (!is_array($data)) throw new \UnexpectedValueException("Invalid variable: $selector");
    return $data;
  }

  protected function getPatternVariableNames($selector) {
    return array_keys($this->getPatternVariable($selector));
  }

  protected function makeMethodSignature(ReflectionClass $reflection, $methodName) {
    $className = $reflection->getName();
    $method = $reflection->getMethod($methodName);
    $start = $method->getStartLine();
    return sprintf("%s::%s(), line %d", $className, $methodName, $start);
  }

  protected function makePropertySignature(ReflectionClass $reflection, $propertyName) {
    return $reflection->getName() . '::$' . $propertyName;
  }
}