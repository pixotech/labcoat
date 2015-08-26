<?php

namespace Labcoat\Styleguide\Files;

class PatternPageFile extends PatternFile implements PatternPageFileInterface {

  public function getContents() {
    // TODO: Implement getContents() method.
  }

  public function getPath() {
    $path = $this->pattern->getStyleguidePathName();
    return "$path/$path.html";
  }
}