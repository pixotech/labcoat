<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Styleguide\StyleguideInterface;

class PatternSourceFile extends PatternFile implements PatternSourceFileInterface {

  public function put(StyleguideInterface $styleguide, $path) {
    $pattern = $styleguide->getPatternContent($this->pattern);
    file_put_contents($path, htmlentities($pattern));
  }

  public function getPath() {
    return $this->makePath($this->pattern->getFilePath('escaped.html'));
  }
}