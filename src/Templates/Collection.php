<?php

namespace Labcoat\Templates;

class Collection implements CollectionInterface {

  /**
   * @var TemplateInterface[]
   */
  protected $templates = [];

  /**
   * @param TemplateInterface $template
   */
  public function add(TemplateInterface $template) {
    $this->templates[] = $template;
  }

  /**
   * @param $name
   * @return TemplateInterface
   */
  public function find($name) {
    foreach ($this->getTemplates() as $template) {
      if ($template->is($name)) return $template;
    }
    throw new \OutOfBoundsException("Unknown template: $name");
  }

  /**
   * @return Loader
   */
  public function getLoader() {
    return new Loader($this);
  }

  /**
   * @return TemplateInterface[]
   */
  public function getTemplates() {
    return $this->templates;
  }
}