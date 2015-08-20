<?php

namespace Pixo\PatternLab\Data;

class ReflectionClass extends \ReflectionClass implements ReflectionClassInterface {

  public function hasPublicGetterMethod($property) {
    return $this->hasPublicMethod($this->getGetterMethodName($property));
  }

  public function hasPublicIsMethod($property) {
    return $this->hasPublicMethod($this->getIsMethodName($property));
  }

  public function hasPublicMethod($name) {
    return $this->hasMethod($name) && $this->getMethod($name)->isPublic();
  }

  public function hasPublicProperty($name) {
    return $this->hasProperty($name) && $this->getProperty($name)->isPublic();
  }

  protected function getGetterMethodName($property) {
    return 'get' . ucfirst($property);
  }

  protected function getIsMethodName($property) {
    return 'is' . ucfirst($property);
  }
}