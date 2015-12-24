<?php

namespace Labcoat\Templates;

class NameFilterIterator extends \FilterIterator {

  protected $name;

  public function __construct(\Iterator $iterator, $name) {
    parent::__construct($iterator);
    $this->name = $name;
  }

  public function accept() {
    $template = $this->current();
    if (!($template instanceof TemplateInterface)) return false;
    return $template->is($this->name);
  }
}