<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript;

class VariableTest extends \PHPUnit_Framework_TestCase {

  public function testString() {
    $name = 'variableName';
    $value = ['one' => 1, 'two' => 2];
    $json = json_encode($value, JSON_PRETTY_PRINT);
    $variable = new Variable($name, $value);
    $string = "var $name = $json;\n";
    $this->assertEquals($string, (string)$variable);
  }
}