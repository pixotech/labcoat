<?php

namespace Labcoat\Configuration;

use Labcoat\PatternLab;

class LabcoatConfiguration extends Configuration {

  protected $root;

  public function __construct($root) {
    $this->root = $root;
    $this->setPatternExtension('twig');
    $this->setHiddenControls(['hay']);
    if ($assets = $this->getDirectoryIfExists('assets')) {
      $this->addAssetDirectory($assets);
    }
    if ($patterns = $this->getDirectoryIfExists('patterns')) {
      $this->setPatternsDirectory($patterns);
    }
    if ($data = $this->getDirectoryIfExists('data')) {
      foreach (glob(PatternLab::makePath([$data, '*.json'])) as $path) {
        if (basename($path) == 'listitems.json') $this->addListItems($path);
        else $this->addGlobalData($path);
      }
    }
    if ($annotations = $this->getFileIfExists(['styleguide', 'annotations.js'])) {
      $this->setAnnotationsFile($annotations);
    }
    if ($styleguideHeader = $this->getFileIfExists(['styleguide', 'header.twig'])) {
      $this->setStyleguideHeader($styleguideHeader);
    }
    if ($styleguideFooter = $this->getFileIfExists(['styleguide', 'footer.twig'])) {
      $this->setStyleguideFooter($styleguideFooter);
    }
    if ($assets = $this->getDirectoryIfExists(['styleguide', 'assets'])) {
      $this->addStyleguideAssetDirectory($assets);
    }
    if ($assets = $this->findStyleguideAssetsDirectory()) {
      $this->addStyleguideAssetDirectory($assets);
    }
    if ($templates = $this->findStyleguideTemplatesDirectory()) {
      $this->setStyleguideTemplatesDirectory($templates);
    }
  }

  protected function findStyleguideAssetsDirectory() {
    if (!$vendor = $this->findVendorDirectory()) return null;
    $path = PatternLab::makePath([$vendor, 'pattern-lab', 'styleguidekit-assets-default', 'dist']);
    return is_dir($path) ? $path : null;
  }

  protected function findStyleguideTemplatesDirectory() {
    if (!$vendor = $this->findVendorDirectory()) return null;
    $path = PatternLab::makePath([$vendor, 'pattern-lab', 'styleguidekit-twig-default', 'views']);
    return is_dir($path) ? $path : null;
  }

  protected function findVendorDirectory() {
    $className = "Composer\\Autoload\\ClassLoader";
    if (!class_exists($className)) return null;
    $c = new \ReflectionClass($className);
    return dirname(dirname($c->getFileName()));
  }

  protected function getDirectoryIfExists($path) {
    $dir = $this->makePath($path);
    return is_dir($dir) ? $dir : null;
  }

  protected function getFileIfExists($path) {
    $file = $this->makePath($path);
    return is_file($file) ? $file : null;
  }

  protected function makePath($path) {
    $path = (array)$path;
    array_unshift($path, $this->root);
    return PatternLab::makePath($path);
  }
}