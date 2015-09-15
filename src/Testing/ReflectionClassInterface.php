<?php

namespace Labcoat\Testing;

interface ReflectionClassInterface extends \Reflector {
  public function getGetterMethodName($property);
  public function getTestMethodName($property);
  public function hasTemplateVariable($name);
  public function hasPublicGetterMethod($property);
  public function hasPublicMethod($name);
  public function hasPublicProperty($name);
  public function hasPublicTestMethod($property);
}