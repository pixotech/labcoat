<?php

namespace Labcoat\PatternLab\Styleguide\Annotations;

class Annotation implements AnnotationInterface {

  protected $comment;

  protected $selector;

  protected $title;

  public function __construct($selector, $title, $comment) {
    $this->selector = $selector;
    $this->title = $title;
    $this->comment = $comment;
  }

  public function jsonSerialize() {
    return [
      'el' => $this->selector,
      'title' => $this->title,
      'comment' => $this->comment,
    ];
  }
}