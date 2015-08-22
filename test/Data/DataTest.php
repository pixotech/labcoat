<?php

namespace Labcoat\Data;

class DataTest extends \PHPUnit_Framework_TestCase {

  public function testGetByKey() {
    $json = <<<JSON
{
  "key": "value"
}
JSON;
    $data = new Data($json);
    $this->assertEquals("value", $data["key"]);
  }

  public function testGetArrayByKey() {
    $json = <<<JSON
{
  "key1": {
    "key2": "value"
  }
}
JSON;
    $data = new Data($json);
    $this->assertEquals(["key2" => "value"], $data["key1"]);
  }

  public function testGetNestedByKey() {
    $json = <<<JSON
{
  "key1": {
    "key2": "value"
  }
}
JSON;
    $data = new Data($json);
    $this->assertEquals("value", $data["key1.key2"]);
  }
}