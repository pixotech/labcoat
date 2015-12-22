<?php

namespace Labcoat\Templates;

class Template implements TemplateInterface {

  protected $file;

  protected $names = [];

  public function __construct(\SplFileInfo $file) {
    $this->file = $file;
  }

  public function getFile() {
    return $this->file;
  }

  public function getNames() {
    return $this->names;
  }
}