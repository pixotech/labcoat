<?php

namespace Labcoat\Templates;

class Loader implements LoaderInterface {

  /**
   * @var CollectionInterface
   */
  protected $collection;

  /**
   * @param CollectionInterface $collection
   */
  public function __construct(CollectionInterface $collection) {
    $this->collection = $collection;
  }

  /**
   * @param string $name
   * @return string
   */
  public function getSource($name) {
    return file_get_contents($this->getTemplatePath($name));
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
      return $this->collection->find($name);
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