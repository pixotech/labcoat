<?php

namespace Labcoat\Configuration;

use Labcoat\Data\Data;
use Labcoat\PatternLab\Patterns\PatternInterface;

class Pattern implements PatternInterface {

  protected $data;

  protected $description;

  protected $file;

  protected $label;

  protected $name;

  protected $path;

  protected $pseudoPatterns = [];

  protected $state;

  protected $subtype;

  protected $type;

  public function getData() {
    return $this->data;
  }

  public function getDescription() {
    return $this->description;
  }

  public function getFile() {
    return $this->file;
  }

  public function getLabel() {
    return $this->label;
  }

  public function getName() {
    return $this->name;
  }

  public function getPath() {
    return $this->path;
  }

  /**
   * @return array
   */
  public function getPseudoPatterns() {
    return $this->pseudoPatterns;
  }

  public function getState() {
    return $this->state;
  }

  public function getSubtype() {
    return $this->subtype;
  }

  public function getType() {
    return $this->type;
  }

  public function hasSubtype() {
    return !empty($this->subtype);
  }

  protected function findData() {
    $data = new Data();
    foreach (glob($this->getDataFilePattern()) as $path) {
      $name = basename($path, '.json');
      list (, $pseudoPattern) = array_pad(explode('~', $name, 2), 2, null);
      if (!empty($pseudoPattern)) {
        $this->pseudoPatterns[$pseudoPattern] = new PseudoPattern($this, $pseudoPattern, $path);
      }
      else {
        $data->merge(Data::load($path));
      }
    }
    $this->data = $data->toArray();
  }

  protected function getDataFilePattern() {
    return dirname($this->getFile()) . DIRECTORY_SEPARATOR . basename($this->getPath()) . '*.json';
  }
}