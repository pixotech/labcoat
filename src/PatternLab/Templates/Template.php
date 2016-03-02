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
  protected $partial;

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

  public function __construct(\SplFileInfo $file, $id = null) {
    parent::__construct($file, $id);
    list($name, $type) = PatternLab::splitPath($id);
    $this->partial = PatternLab::makePartial($type, $name);
  }

  /**
   * @return array
   */
  public function getData() {
    if (!isset($this->data)) $this->findData();
    return $this->data;
  }

  public function getPartial() {
    return $this->partial;
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

  public function is($name) {
    if ($this->isPath($name)) $name = $this->makePartialFromPath($name);
    return $name == $this->getPartial();
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

  protected function isPath($selector) {
    return strpbrk($selector, DIRECTORY_SEPARATOR . '/') !== false;
  }

  protected function loadData($path) {
    return json_decode(file_get_contents($path), true);
  }

  protected function makePartialFromPath($path) {
    list($name, $type) = PatternLab::splitPath($this->stripExtension($path));
    return PatternLab::makePartial($type, $name);
  }

  protected function stripExtension($path) {
    $ext = '.twig';
    if (substr($path, 0 - strlen($ext)) == $ext) $path = substr($path, 0, 0 - strlen($ext));
    return $path;
  }
}