<?php

namespace Labcoat\PatternLab\Patterns;

class ConfigurationTest extends \PHPUnit_Framework_TestCase {

  public function testConfigurationName() {
    $name = "Pattern Name";
    $config = new Configuration(['name' => $name]);
    $this->assertEquals($name, $config->getName());
  }

  public function testConfigurationSubtype() {
    $subtype = "subtype-name";
    $config = new Configuration(['subtype' => $subtype]);
    $this->assertEquals($subtype, $config->getSubtype());
  }

  public function testConfigurationType() {
    $type = "type-name";
    $config = new Configuration(['type' => $type]);
    $this->assertEquals($type, $config->getType());
  }

  public function testConfigurationState() {
    $state = "state";
    $config = new Configuration(['state' => $state]);
    $this->assertEquals($state, $config->getState());
  }
}