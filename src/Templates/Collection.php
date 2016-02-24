<?php

namespace Labcoat\Templates;

class Collection implements CollectionInterface {

  protected $templates = [];

  public function add(TemplateInterface $template) {
    $this->templates[] = $template;
  }

  public function find($name) {
    foreach ($this->getTemplates() as $template) {
      if ($template->is($name)) return $template;
    }
    throw new \OutOfBoundsException("Unknown template: $name");
  }

  /**
   * @return TemplateInterface[]
   */
  public function getTemplates() {
    return $this->templates;
  }
}