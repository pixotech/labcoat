<?php

namespace Labcoat\Templates;

class Collection implements CollectionInterface, \Twig_LoaderInterface {

  /**
   * @var TemplateInterface[]
   */
  protected $templates = [];

  /**
   * @param string $name
   * @return TemplateInterface
   */
  public function __invoke($name) {
    return $this->find($name);
  }

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
   * @param string $name
   * @return string
   */
  public function getCacheKey($name) {
    return $this->getTemplate($name)->getId();
  }

  /**
   * @param string $name
   * @return string
   */
  public function getSource($name) {
    return file_get_contents($this->getTemplatePath($name));
  }

  /**
   * @return TemplateInterface[]
   */
  public function getTemplates() {
    return $this->templates;
  }

  /**
   * @param string $name
   * @param int $time
   * @return bool
   */
  public function isFresh($name, $time) {
    return !($time < $this->getTemplateTimestamp($name));
  }

  /**
   * @param string $name
   * @return TemplateInterface
   * @throws \Twig_Error_Loader
   */
  protected function getTemplate($name) {
    try {
      return $this->find($name);
    }
    catch (\OutOfBoundsException $e) {
      throw new \Twig_Error_Loader($e->getMessage());
    }
  }

  /**
   * @param string $name
   * @return string
   */
  protected function getTemplatePath($name) {
    return $this->getTemplate($name)->getFile()->getPathname();
  }

  /**
   * @param string $name
   * @return int
   */
  protected function getTemplateTimestamp($name) {
    return $this->getTemplate($name)->getTime()->getTimestamp();
  }
}