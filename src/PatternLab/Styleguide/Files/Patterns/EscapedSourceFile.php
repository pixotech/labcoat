<?php

namespace Labcoat\PatternLab\Styleguide\Files\Patterns;

use Labcoat\PatternLab;

class EscapedSourceFile extends PatternFile implements EscapedSourceFileInterface {

  public function put($path) {
    file_put_contents($path, htmlentities($this->pattern->getExample()));
  }

  public function getPath() {
    $path = $this->pattern->getId();
    return PatternLab::makePath(['patterns', $path, "$path.escaped.html"]);
  }
}