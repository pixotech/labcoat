<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript;

use Labcoat\PatternLab\Styleguide\Annotations\AnnotationInterface;
use Labcoat\Generator\Files\File;

class AnnotationsFile extends File implements AnnotationsFileInterface {

  protected $annotations = [];

  public function __construct(array $annotations = []) {
    array_map([$this, 'addAnnotation'], $annotations);
  }

  public function __toString() {
    return "var comments = " . json_encode(['comments' => $this->annotations]) . ';';
  }

  public function addAnnotation(AnnotationInterface $annotation) {
    $this->annotations[] = $annotation;
  }

  public function getPath() {
    return $this->makePath(['annotations', 'annotations.js']);
  }

  public function getTime() {
    return time();
  }

  public function put($path) {
    file_put_contents($path, $this);
  }
}