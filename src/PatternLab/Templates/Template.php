<?php

namespace Labcoat\PatternLab\Templates;

class Template extends \Labcoat\Templates\Template implements TemplateInterface {

  /**
   * @var array
   */
  protected $data;

  /**
   * @var array
   */
  protected $variants;

  /**
   * @return Collection
   */
  protected static function makeCollection() {
    return new Collection();
  }

  /**
   * @return array
   */
  public function getData() {
    if (!isset($this->data)) $this->findData();
    return $this->data;
  }

  /**
   * @return array
   */
  public function getVariants() {
    if (!isset($this->variants)) $this->findVariants();
    return $this->variants;
  }

  /**
   * @return bool
   */
  public function hasData() {
    if (!isset($this->data)) $this->findData();
    return !empty($this->data);
  }

  /**
   * @return bool
   */
  public function hasVariants() {
    if (!isset($this->variants)) $this->findVariants();
    return !empty($this->variants);
  }

  protected function findData() {
    try {
      $file = $this->getSibing('json');
      $this->data = $this->loadData($file->getPathname());
    }
    catch (\OutOfBoundsException $e) {
      $this->data = [];
    }
  }

  protected function findVariants() {
    $this->variants = [];
    foreach (glob($this->getVariantFilePattern()) as $path) {
      list (, $name) = array_pad(explode('~', basename($path, '.json'), 2), 2, null);
      $this->variants[$name] = $this->loadData($path);
    }
  }

  /**
   * @return string
   */
  protected function getVariantFilePattern() {
    return $this->getPathWithoutExtension() . '~*.json';
  }

  protected function loadData($path) {
    return json_decode(file_get_contents($path), true);
  }
}