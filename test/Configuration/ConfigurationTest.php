<?php

namespace Labcoat\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase {

  public function testGet() {
    $yaml = <<<YAML
testkey: testvalue
YAML;
    $config = new Configuration($yaml);
    $this->assertEquals('testvalue', $config->get('testkey'));
  }
}