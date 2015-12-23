<?php

namespace Labcoat\Styleguide\Files\Patterns;

use Labcoat\Styleguide\StyleguideInterface;

class EscapedSourceFile extends PatternFile implements EscapedSourceFileInterface {

  public function put(StyleguideInterface $styleguide, $path) {
    file_put_contents($path, htmlentities($this->pattern->getContent()));
  }

  public function getPath() {
    return $this->pattern->getEscapedSourcePath();
  }
}