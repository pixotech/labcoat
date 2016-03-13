<?php

namespace Labcoat\PatternLab\Styleguide\Files\Patterns;

use Labcoat\Generator\Paths\Path;
use Labcoat\PatternLab;

class TemplateFile extends PatternFile implements TemplateFileInterface {

  public function put($path) {
    $template = $this->getTemplateContent();
    file_put_contents($path, htmlentities($template));
  }

  public function getPath() {
    $dir = $this->pattern->getStyleguideDirectoryName();
    return new Path("patterns/$dir/$dir.twig");
  }

  protected function getTemplateContent() {
    return $this->pattern->getTemplateContent();
  }
}