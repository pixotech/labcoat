<?php

namespace Labcoat\Styleguide\Files;

class PatternEscapedHtmlFile extends PatternFile implements PatternEscapedHtmlFileInterface {

  public function getContents() {
    // TODO: Implement getContents() method.
  }

  public function getPath() {
    $path = $this->pattern->getStyleguidePathName();
    return "$path/$path.escaped.html";
  }
}