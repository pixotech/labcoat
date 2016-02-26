<?php

namespace Labcoat\PatternLab\Templates;

use Labcoat\PatternLab\PatternLab;

class Template extends \Labcoat\Templates\Template implements TemplateInterface {

  /**
   * @var array
   */
  protected $data;

  /**
   * @var string
   */
  protected $name;

  /**
   * @var string
   */
  protected $subtype;

  /**
   * @var string
   */
  protected $type;

  /**
   * @var array
   */
  protected $variants;

  /**
   * @param \SplFileInfo $file
   * @param string $id
   */
  public function __construct(\SplFileInfo $file, $id = null) {
    parent::__construct($file, $id);
    $this->splitId();
  }

  /**
   * @return array
   */
  public function getData() {
    if (!isset($this->data)) $this->findData();
    return $this->data;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getSubtype() {
    return $this->subtype;
  }

  /**
   * @return string
   */
  public function getType() {
    return $this->type;
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
  public function hasSubtype() {
    return !empty($this->subtype);
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

  protected function splitId() {
    list($this->name, $this->type, $this->subtype) = PatternLab::splitPath($this->getId());
  }
}