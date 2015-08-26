<?php

namespace Labcoat\Styleguide\Files;

class PatternEscapedHtmlFile extends PatternFile implements PatternEscapedHtmlFileInterface {

  public function getContents() {
    // TODO: Implement getContents() method.
  }

  public function getPath() {
    $path = $this->pattern->getStyleguidePathName();
    return $this->makePath(['patterns', $path, "$path.escaped.html"]);
  }
}