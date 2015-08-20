<?php

namespace Labcoat\Data;

class ReflectionClass extends \ReflectionClass implements ReflectionClassInterface {

  public function hasPublicGetterMethod($property) {
    return $this->hasPublicMethod($this->getGetterMethodName($property));
  }

  public function hasPublicMethod($name) {
    return $this->hasMethod($name) && $this->getMethod($name)->isPublic();
  }

  public function hasPublicProperty($name) {
    return $this->hasProperty($name) && $this->getProperty($name)->isPublic();
  }

  public function hasPublicTestMethod($property) {
    return $this->hasPublicMethod($this->getTestMethodName($property));
  }

  protected function getGetterMethodName($property) {
    return 'get' . ucfirst($property);
  }

  protected function getTestMethodName($property) {
    return 'is' . ucfirst($property);
  }
}