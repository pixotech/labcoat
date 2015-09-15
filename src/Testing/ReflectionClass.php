<?php

namespace Labcoat\Testing;

class ReflectionClass extends \ReflectionClass implements ReflectionClassInterface {

  public function getGetterMethodName($property) {
    return 'get' . ucfirst($property);
  }

  public function getTestMethodName($property) {
    return 'is' . ucfirst($property);
  }

  /**
   * @see http://twig.sensiolabs.org/doc/templates.html
   */
  public function hasTemplateVariable($name) {
    if ($this->hasPublicProperty($name)) return true;
    if ($this->hasPublicMethod($name)) return true;
    if ($this->hasPublicGetterMethod($name)) return true;
    if ($this->hasPublicTestMethod($name)) return true;
    return false;
  }

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
}