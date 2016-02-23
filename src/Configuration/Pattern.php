<?php

namespace Labcoat\Configuration;

use Labcoat\Data\Data;
use Labcoat\PatternLab\Name;
use Labcoat\PatternLab\PatternInterface;
use Labcoat\PatternLab\Styleguide\Patterns\Path;
use Labcoat\PatternLab\Styleguide\Patterns\PseudoPattern;

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

  public static function makeFromFile($dir, $path, $extension) {
    $pattern = new static();
    $pattern->path = $path;
    $pattern->file = $dir . DIRECTORY_SEPARATOR . $path . '.' . $extension;
    $path = new Path($path);
    $pattern->name = $path->getName();
    $pattern->label = (new Name($pattern->name))->capitalized();
    if ($path->hasType()) $pattern->type = $path->getType();
    if ($path->hasSubtype()) $pattern->subtype = $path->getSubtype();
    return $pattern;
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

  public function hasType() {
    return !empty($this->type);
  }

  protected function findData() {
    $this->data = new Data();
    foreach (glob($this->getDataFilePattern()) as $path) {
      $name = basename($path, '.json');
      list (, $pseudoPattern) = array_pad(explode('~', $name, 2), 2, null);
      if (!empty($pseudoPattern)) {
        $this->pseudoPatterns[$pseudoPattern] = new PseudoPattern($this, $pseudoPattern, $path);
      }
      else {
        $this->data->merge(Data::load($path));
      }
    }
  }

  protected function getDataFilePattern() {
    return dirname($this->getFile()) . DIRECTORY_SEPARATOR . basename($this->getPath()) . '*.json';
  }
}