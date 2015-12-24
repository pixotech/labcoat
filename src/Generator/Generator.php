<?php

namespace Labcoat\Generator;

use Labcoat\PatternLab;
use Labcoat\Generator\Files\FileInterface;
use Labcoat\Styleguide\StyleguideInterface;

class Generator implements GeneratorInterface {

  protected $clean = false;
  protected $force = true;
  protected $path;
  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide, $path) {
    $this->styleguide = $styleguide;
    $this->path = $path;
  }

  public function __invoke() {
    $report = new Report();
    $paths = $this->getExistingPaths();
    /** @var \Labcoat\Generator\Files\FileInterface $file */
    foreach ($this->styleguide as $path => $file) {
      $report->addEvent($this->handleFile($file, $path));
      if (false !== $i = array_search($path, $paths)) {
        unset($paths[$i]);
      }
    }
    foreach ($paths as $path) {
      if ($this->clean) {
        $report->addEvent($this->deleteFile($path));
      }
      else {
        $event = new FileEvent($path);
        $event->stop(FileEvent::SKIPPED);
        $report->addEvent($event);
      }
    }
    $report->stop();
    return $report;
  }

  protected function deleteFile($path) {
    $destination = $this->makePath($path);
    if (is_file($destination)) unlink($destination);
    $event = new FileEvent($path);
    $event->stop(FileEvent::DELETED);
    return $event;
  }

  /**
   * @param $path
   */
  protected function ensureDirectory($path) {
    if (!is_dir($path)) mkdir($path, 0777, true);
  }

  /**
   * @param $path
   */
  protected function ensurePathDirectory($path) {
    $this->ensureDirectory(dirname($path));
  }

  protected function getExistingPaths() {
    $paths = [];
    $dir = new \RecursiveDirectoryIterator($this->path, \FilesystemIterator::SKIP_DOTS);
    $files = new \RecursiveIteratorIterator($dir);
    $pos = strlen($this->path . DIRECTORY_SEPARATOR);
    foreach ($files as $file => $obj) {
      $paths[] = substr($file, $pos);
    }
    return $paths;
  }

  protected function handleFile(FileInterface $file, $path) {
    $event = new FileEvent($path);
    $destination = $this->makePath($path);
    $fileTime = is_file($destination) ? filemtime($destination) : 0;
    if ($this->force || $fileTime < $file->getTime()) {
      $this->ensurePathDirectory($destination);
      $file->put($destination);
      $event->stop(FileEvent::UPDATED);
    }
    else {
      $event->stop(FileEvent::SKIPPED);
    }
    return $event;
  }

  protected function makePath($path) {
    return PatternLab::makePath([$this->path, $path]);
  }
}