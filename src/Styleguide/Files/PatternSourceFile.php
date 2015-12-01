<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Styleguide\StyleguideInterface;

class PatternSourceFile extends PatternFile implements PatternSourceFileInterface {

  public function put(StyleguideInterface $styleguide, $path) {
    file_put_contents($path, $this->pattern->getContent());
  }

  public function getPath() {
    return $this->pattern->getSourcePath();
  }
}