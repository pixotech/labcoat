<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript;

class Variable implements VariableInterface {

  /**
   * @var string
   */
  protected $name;

  /**
   * @var mixed
   */
  protected $value;

  /**
   * @param $name
   * @param $value
   */
  public function __construct($name, $value) {
    $this->name = $name;
    $this->value = $value;
  }

  /**
   * @return string
   */
  public function __toString() {
    return sprintf("var %s = %s;\n", $this->getName(), $this->getJson());
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return mixed
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * @param string $name
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * @param mixed $value
   */
  public function setValue($value) {
    $this->value = $value;
  }

  /**
   * @return string
   */
  protected function getJson() {
    return json_encode($this->getValue(), JSON_PRETTY_PRINT);
  }
}