<?php

namespace Labcoat\Styleguide\Files\Patterns;

use Labcoat\PatternLab;
use Labcoat\Styleguide\StyleguideInterface;

class SourceFile extends PatternFile implements SourceFileInterface {

  public function put(StyleguideInterface $styleguide, $path) {
    file_put_contents($path, $this->pattern->getContent());
  }

  public function getPath() {
    $path = $this->pattern->getId();
    return PatternLab::makePath(['patterns', $path, "$path.pattern.html"]);
  }
}