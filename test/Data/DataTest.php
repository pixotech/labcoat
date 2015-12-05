<?php

namespace Labcoat\Data;

class DataTest extends \PHPUnit_Framework_TestCase {

  protected $files = [];

  protected function tearDown() {
    parent::tearDown();
    foreach ($this->files as $file) unlink($file);
    $this->files = [];
  }

  public function testDataArray() {
    $array = ['one' => 'two'];
    $data = new Data($array);
    $this->assertEquals($array, $data->toArray());
  }

  public function testDataFromString() {
    $array = ['one' => 'two'];
    $data = Data::parse(json_encode($array));
    $this->assertEquals($array, $data->toArray());
  }

  public function testDataFromFile() {
    $file = $this->makeFile();
    $array = ['one' => 'two'];
    file_put_contents($file, json_encode($array));
    $data = Data::load($file);
    $this->assertEquals($array, $data->toArray());
  }

  protected function makeFile($prefix = 'data') {
    $file = tempnam(sys_get_temp_dir(), $prefix);
    $this->files[] = $file;
    return $file;
  }
}