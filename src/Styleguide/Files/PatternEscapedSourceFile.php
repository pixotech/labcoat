<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Styleguide\StyleguideInterface;

class PatternEscapedSourceFile extends PatternFile implements PatternEscapedSourceFileInterface {

  public function put(StyleguideInterface $styleguide, $path) {
    file_put_contents($path, htmlentities($this->pattern->getContent()));
  }

  public function getPath() {
    return $this->pattern->getEscapedSourcePath();
  }
}