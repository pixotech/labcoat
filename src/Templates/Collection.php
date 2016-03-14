<?php

namespace Labcoat\Templates;

class Collection implements CollectionInterface, \IteratorAggregate {

  /**
   * @var string
   */
  protected static $templateExtension = 'twig';

  /**
   * @var TemplateInterface[]
   */
  protected $templates = [];

  /**
   * @param string $dir
   * @return Collection
   */
  public static function fromDirectory($dir) {
    $collection = new static();
    foreach (static::makeDirectoryIterator($dir) as $path => $file) {
      try {
        $collection->add(new Template($file, static::getIdFromPath($path, $dir)));
      }
      catch (\InvalidArgumentException $e) {
        continue;
      }
    }
    return $collection;
  }

  /**
   * @return string
   */
  protected static function getFileRegex() {
    return '|\.' . preg_quote(static::$templateExtension) . '$|';
  }

  /**
   * @param string $dir
   * @return \RecursiveIteratorIterator
   */
  protected static function getFilesIterator($dir) {
    return new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
  }

  /**
   * @param string $path
   * @param string $dir
   * @return string
   */
  protected static function getIdFromPath($path, $dir) {
    return str_replace(DIRECTORY_SEPARATOR, '/', static::getRelativePathWithoutExtension($path, $dir));
  }

  /**
   * @param string $path
   * @param string $dir
   * @return string
   */
  protected static function getRelativePathWithoutExtension($path, $dir) {
    return substr($path, strlen($dir) + 1, -1 - strlen(static::$templateExtension));
  }

  /**
   * @param string $dir
   * @return \RegexIterator
   */
  protected static function makeDirectoryIterator($dir) {
    return new \RegexIterator(static::getFilesIterator($dir), static::getFileRegex(), \RegexIterator::MATCH);
  }

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
   * @return \ArrayIterator
   */
  public function getIterator() {
    return new \ArrayIterator($this->getTemplates());
  }

  /**
   * @return string
   */
  public function getSource($name) {
    return $this->find($name)->getSource();
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