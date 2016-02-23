<?php

namespace Labcoat\PatternLab;

use Labcoat\PatternLab\Styleguide\Patterns\Path;

class Pattern implements PatternInterface {

  protected $description;

  protected $file;

  protected $label;

  protected $name;

  protected $path;

  protected $state;

  protected $subtype;

  protected $type;

  public static function makeFromFile($dir, $path, $extension) {
    $pattern = new static();
    $pattern->file = implode(DIRECTORY_SEPARATOR, [$dir, $path, $extension]);
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
}