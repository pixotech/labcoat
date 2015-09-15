<?php

namespace Labcoat\Testing;

use Labcoat\PatternLabInterface;

class HasPatternDataConstraint extends \PHPUnit_Framework_Constraint {

  protected $globalData;

  protected $patternlab;

  public static function explodeSelector($selector) {
    return array_pad(explode('#', $selector, 2), 2, null);
  }

  public static function getDataVariable($data, $variable) {
    foreach (explode('.', $variable) as $v) {
      if (!isset($data[$v])) return null;
      $data = $data[$v];
    }
    return $data;
  }

  public static function makeVariableSelector($selector, $variable) {
    list($pattern, $parentVariable) = self::explodeSelector($selector);
    $variable = $parentVariable ? ($parentVariable . '.' . $variable) : $variable;
    return $pattern . '#' . $variable;
  }

  public function __construct(PatternLabInterface $patternlab) {
    parent::__construct();
    $this->patternlab = $patternlab;
  }

  public function toString() {
    return 'contain the required pattern variables';
  }

  public function matches(array $dataClasses) {
    foreach ($dataClasses as $selector => $dataClassName) {
      $reflection = new ReflectionClass($dataClassName);
      foreach ($this->getVariableNames($selector) as $name) {
        if (!$reflection->hasTemplateVariable($name)) return false;
      }
    }
    return true;
  }

  protected function additionalFailureDescription($dataClasses) {
    $description = "\n";
    foreach ($dataClasses as $selector => $dataClassName) {
      $reflection = new ReflectionClass($dataClassName);
      foreach ($this->getVariableNames($selector) as $name) {
        $description .= sprintf("%s\n", $this->makeVariableSelector($selector, $name));
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

  protected function getGlobalData($refresh = false) {
    if (!isset($this->globalData) || $refresh) $this->globalData = $this->patternlab->getGlobalData();
    return $this->globalData;
  }

  protected function getData($selector) {
    list($pattern, $variable) = $this->explodeSelector($selector);
    $data = $this->getPatternData($pattern);
    return $variable ? $this->getDataVariable($data, $variable) : $data;
  }

  protected function getPatternData($name) {
    $data = $this->getGlobalData();
    /** @var \Labcoat\Patterns\HasDataInterface $pattern */
    $pattern = $this->patternlab->getPattern($name);
    foreach ($pattern->getDataFiles() as $file) {
      $json = json_decode(file_get_contents($file), true);
      $data = array_replace_recursive($data, $json);
    }
    return $data;
  }

  protected function getVariableNames($selector) {
    return array_keys($this->getData($selector));
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