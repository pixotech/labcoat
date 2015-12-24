<?php

namespace Labcoat\Templates;

class Collection implements CollectionInterface {

  protected $templates = [];

  public static function fromDirectory($dir, $ext = 'twig') {
    $collection = new Collection();
    foreach (static::makeDirectoryIterator($dir, $ext) as $path => $file) {
      $id = substr($path, strlen($dir) + 1, -1 - strlen($ext));
      $collection->add(new Template($file, $id));
    }
    return $collection;
  }

  protected static function makeDirectoryIterator($dir, $ext = 'twig') {
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
    $regex = '|\.' . preg_quote($ext) . '$|';
    return new \RegexIterator($files, $regex, \RegexIterator::MATCH);
  }

  public function add(TemplateInterface $template) {
    $this->templates[] = $template;
  }

  public function find($name) {
    $filtered = new NameFilterIterator($this->getTemplatesIterator(), $name);
    $filtered->rewind();
    return $filtered->valid() ? $filtered->current() : null;
  }

  protected function getTemplatesIterator() {
    return new \ArrayIterator($this->templates);
  }
}