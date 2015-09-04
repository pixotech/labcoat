<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Styleguide\StyleguideInterface;

class PatternSourceFile extends PatternFile implements PatternSourceFileInterface {

  public function put(StyleguideInterface $styleguide, $path) {
    file_put_contents($path, htmlentities($this->pattern->getContent()));
  }

  public function getPath() {
    return $this->makePath($this->pattern->getFilePath('escaped.html'));
  }
}