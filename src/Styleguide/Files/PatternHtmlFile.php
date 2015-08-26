<?php

namespace Labcoat\Styleguide\Files;

class PatternHtmlFile extends PatternFile implements PatternHtmlFileInterface {

  public function getContents() {
    return $this->render();
  }

  public function getPath() {
    $path = $this->pattern->getStyleguidePathName();
    return $this->makePath(['patterns', $path, "$path.raw.html"]);
  }
}