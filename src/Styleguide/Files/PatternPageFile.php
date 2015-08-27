<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Styleguide\Pages\PatternPage;

class PatternPageFile extends PatternFile implements PatternPageFileInterface {

  public function getContents() {
    $page = new PatternPage($this->styleguide, $this->pattern);
    return $page->__toString();
  }

  public function getPath() {
    $path = $this->pattern->getStyleguidePathName();
    return $this->makePath(['patterns', $path, "$path.html"]);
  }
}