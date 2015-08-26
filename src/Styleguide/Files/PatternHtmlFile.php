<?php

namespace Labcoat\Styleguide\Files;

class PatternHtmlFile extends PatternFile implements PatternHtmlFileInterface {

  public function getContents() {
    // TODO: Implement getContents() method.
  }

  public function getPath() {
    $path = $this->pattern->getStyleguidePathName();
    return "$path/$path.raw.html";
  }
}