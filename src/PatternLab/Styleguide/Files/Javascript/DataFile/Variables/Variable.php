<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables;

abstract class Variable implements VariableInterface {

  public function __toString() {
    return sprintf("var %s = %s;", $this->getName(), $this->getJson());
  }

  protected function getJson() {
    return json_encode($this->getValue(), JSON_PRETTY_PRINT);
  }
}