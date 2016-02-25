<?php

namespace Labcoat\Templates;

class Template implements TemplateInterface {

  protected static $extension = 'twig';

  protected $id;

  protected $file;

  public static function inDirectory($dir) {
    $collection = static::makeCollection();
    foreach (static::makeDirectoryIterator($dir) as $path => $file) {
      try {
        $collection->add(new static($file, static::getIdFromPath($path, $dir)));
      }
      catch (\InvalidArgumentException $e) {
        continue;
      }
    }
    return $collection;
  }

  protected static function getFileRegex() {
    return '|\.' . preg_quote(static::$extension) . '$|';
  }

  protected static function getFilesIterator($dir) {
    return new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
  }

  protected static function getIdFromPath($path, $dir) {
    return str_replace(DIRECTORY_SEPARATOR, '/', static::getRelativePathWithoutExtension($path, $dir));
  }

  protected static function getRelativePathWithoutExtension($path, $dir) {
    return substr($path, strlen($dir) + 1, -1 - strlen(static::$extension));
  }

  protected static function makeCollection() {
    return new Collection();
  }

  protected static function makeDirectoryIterator($dir) {
    return new \RegexIterator(static::getFilesIterator($dir), static::getFileRegex(), \RegexIterator::MATCH);
  }

  public function __construct(\SplFileInfo $file, $id = null) {
    $this->file = $file;
    if (isset($id)) $this->id;
  }

  public function __invoke(\Twig_Environment $parser, array $vars = []) {
    return $parser->render($this->getId(), $vars);
  }

  public function __toString() {
    return $this->getId();
  }

  public function getFile() {
    return $this->file;
  }

  public function getId() {
    return $this->id;
  }

  public function getTime() {
    $time = new \DateTime();
    $time->setTimestamp($this->getFileTimestamp());
    return $time;
  }

  public function is($name) {
    return $name == $this->getId();
  }

  protected function getFileTimestamp() {
    return $this->getFile()->getMTime();
  }
}