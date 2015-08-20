<?php

namespace Pixo\PatternLab\Data;

interface ReflectionClassInterface extends \Reflector {
  public function hasPublicGetterMethod($property);
  public function hasPublicIsMethod($property);
  public function hasPublicMethod($name);
  public function hasPublicProperty($name);
}