<?php

namespace Labcoat\Filesystem;

class Directory extends File implements DirectoryInterface {

  /**
   * @param $path
   * @return Directory
   */
  public function getDirectory($path) {
    return new Directory($this->patternlab, $path, $this);
  }

  /**
   * @param $path
   * @return File
   */
  public function getFile($path) {
    if (is_array($path)) $path = implode(static::SLASH, $path);
    return new File($this->patternlab, $path, $this);
  }

  /**
   * @return File[]
   */
  public function getFiles() {
    return $this->makeFilesFromIterator($this->getFilesIterator());
  }

  /**
   * @param $extension
   * @return File[]
   */
  public function getFilesWithExtension($extension) {
    return $this->makeFilesFromIterator($this->getFilesWithExtensionIterator($extension));
  }

  public function getPatternFiles() {
    return $this->getFilesWithExtension($this->patternlab->getPatternExtension());
  }

  protected function getFilesIterator() {
    $flags = \FilesystemIterator::CURRENT_AS_PATHNAME | \FilesystemIterator::SKIP_DOTS;
    return new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->getFullPath(), $flags));
  }

  protected function getFilesWithExtensionIterator($extension) {
    $pattern = '|\.' . preg_quote($extension) . '$|';
    return new \RegexIterator($this->getFilesIterator(), $pattern, \RegexIterator::MATCH);
  }

  protected function makeFilesFromIterator(\Iterator $iterator) {
    $files = [];
    foreach ($iterator as $path) {
      $files[$path] = $this->getFile($this->makeRelativePath($path));
    }
    asort($files);
    return $files;
  }

  protected function makeRelativePath($path) {
    return substr($path, strlen($this->getFullPath()) + 1);
  }
}