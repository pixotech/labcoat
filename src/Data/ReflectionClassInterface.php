<?php

namespace Labcoat\Data;

interface ReflectionClassInterface extends \Reflector {
  public function hasPublicGetterMethod($property);
  public function hasPublicMethod($name);
  public function hasPublicProperty($name);
  public function hasPublicTestMethod($property);
}