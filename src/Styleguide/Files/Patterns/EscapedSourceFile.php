<?php

namespace Labcoat\Styleguide\Files\Patterns;

use Labcoat\PatternLab;

class EscapedSourceFile extends PatternFile implements EscapedSourceFileInterface {

  public function put($path) {
    file_put_contents($path, htmlentities($this->pattern->getContent()));
  }

  public function getPath() {
    $path = $this->pattern->getId();
    return PatternLab::makePath(['patterns', $path, "$path.escaped.html"]);
  }
}