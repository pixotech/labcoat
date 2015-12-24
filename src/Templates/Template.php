<?php

namespace Labcoat\Templates;

class Template implements TemplateInterface {

  protected $id;

  protected $file;

  public function __construct(\SplFileInfo $file, $id = null) {
    $this->file = $file;
    if (isset($id)) $this->id;
  }

  public function getFile() {
    return $this->file;
  }

  public function getId() {
    return $this->id;
  }

  public function getNames() {
    return isset($this->id) ? [$this->id] : [];
  }

  public function is($name) {
    return in_array($name, $this->getNames());
  }
}