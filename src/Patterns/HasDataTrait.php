<?php

namespace Labcoat\Patterns;

trait HasDataTrait {

  protected $data;
  protected $dataFiles = [];
  protected $dataTime;

  public function getData() {
    if (!isset($this->data)) {
      $this->data = [];
      foreach ($this->dataFiles as $file) {
        $this->data = array_merge_recursive($this->data, json_decode(file_get_contents($file), true));
      }
    }
    return $this->data;
  }

  public function getDataFiles() {
    return $this->dataFiles;
  }

  public function getDataTime() {
    if (!isset($this->dataTime)) {
      $this->dataTime = 0;
      foreach ($this->dataFiles as $file) {
        $this->dataTime = max($this->dataTime, filemtime($file));
      }
    }
    return $this->dataTime;
  }
}