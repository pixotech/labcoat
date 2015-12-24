<?php

namespace Labcoat\PatternLab\Styleguide\Files\Patterns;

use Labcoat\Generator\Paths\Path;
use Labcoat\PatternLab;

class SourceFile extends PatternFile implements SourceFileInterface {

  public function put($path) {
    file_put_contents($path, $this->pattern->getExample());
  }

  public function getPath() {
    $path = $this->pattern->getId();
    return new Path("patterns/$path/$path.pattern.html");
  }
}