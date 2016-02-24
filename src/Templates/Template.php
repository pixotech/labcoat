<?php

namespace Labcoat\Templates;

class Template implements TemplateInterface {

  protected static $extension = 'twig';

  protected $id;

  protected $file;

  public static function inDirectory($dir) {
    $collection = static::makeCollection();
    foreach (static::makeDirectoryIterator($dir) as $path => $file) {
      $collection->add(new static($file, static::getIdFromPath($path, $dir)));
    }
    return $collection;
  }

  protected static function getIdFromPath($path, $dir) {
    return substr($path, strlen($dir) + 1, -1 - strlen(static::$extension));
  }

  protected static function makeCollection() {
    return new Collection();
  }

  protected static function makeDirectoryIterator($dir) {
    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
    $regex = '|\.' . preg_quote(static::$extension) . '$|';
    return new \RegexIterator($files, $regex, \RegexIterator::MATCH);
  }

  public function __construct(\SplFileInfo $file, $id = null) {
    $this->file = $file;
    if (isset($id)) $this->id;
  }

  public function getFile() {
    return $this->file;
  }

  public function getId() {
    return $this->id;
  }

  public function getNames() {
    return isset($this->id) ? [$this->id] : [];
  }

  public function getTime() {
    $time = new \DateTime();
    $time->setTimestamp($this->file->getMTime());
    return $time;
  }

  public function is($name) {
    return in_array($name, $this->getNames());
  }
}