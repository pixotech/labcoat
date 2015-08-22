<?php

namespace Labcoat\Filesystem;

use Labcoat\PatternLabInterface;

class File implements FileInterface {

  const SLASH = DIRECTORY_SEPARATOR;

  protected $path;
  protected $patternlab;
  protected $root;

  public function __construct(PatternLabInterface $patternlab, $path, DirectoryInterface $root = null) {
    $this->patternlab = $patternlab;
    $this->root = $root;
    $this->path = $path;
  }

  public function getDirectoryNames() {
    return explode(self::SLASH, dirname($this->getPath()));
  }

  public function getExtension() {
    $name = basename($this->path);
    $dot = strpos($name, '.');
    return $dot === false ? null : substr($name, $dot + 1);
  }

  public function getFullPath() {
    $path = $this->getPath();
    if ($this->hasRoot()) {
      $prefix = rtrim($this->getRoot()->getFullPath(), self::SLASH);
      $path = $prefix . self::SLASH . $path;
    }
    return $path;
  }

  public function getPath() {
    return $this->path;
  }

  public function getPathSegments() {
    return explode(self::SLASH, $this->getPath());
  }

  public function getPathWithoutExtension() {
    $ext = $this->getExtension();
    return $ext ? substr($this->path, 0, -1 - strlen($ext)) : $this->path;
  }

  /**
   * @return DirectoryInterface
   */
  public function getRoot() {
    return $this->root;
  }

  public function hasDirectoryName($directories) {
    return count(array_intersect($this->getDirectoryNames(), (array)$directories)) > 0;
  }

  public function hasExtension($extension) {
    return in_array($this->getExtension(), (array)$extension);
  }

  public function hasIgnoredExtension() {
    return $this->hasExtension($this->patternlab->getIgnoredExtensions());
  }

  public function hasPathSegment($segments) {
    return count(array_intersect($this->getPathSegments(), (array)$segments)) > 0;
  }

  public function hasPatternExtension() {
    return $this->hasExtension($this->patternlab->getPatternExtension());
  }

  public function hasRoot() {
    return isset($this->root);
  }

  public function isHidden() {
    return false !== strpos(self::SLASH . $this->getPath(),  self::SLASH . '_');
  }

  public function isIgnored() {
    return $this->hasIgnoredExtension() || $this->isInIgnoredDirectory();
  }

  public function isInIgnoredDirectory() {
    return $this->hasDirectoryName($this->patternlab->getIgnoredDirectories());
  }
}