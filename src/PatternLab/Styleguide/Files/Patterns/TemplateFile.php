<?php

namespace Labcoat\PatternLab\Styleguide\Files\Patterns;

use Labcoat\PatternLab;

class TemplateFile extends PatternFile implements TemplateFileInterface {

  public function put($path) {
    $template = $this->getTemplateContent();
    file_put_contents($path, htmlentities($template));
  }

  public function getPath() {
    $path = $this->pattern->getId();
    return PatternLab::makePath(['patterns', $path, "$path.twig"]);
  }

  protected function getTemplateContent() {
    return file_get_contents($this->pattern->getFile());
  }

  protected function getTemplateExtension() {
    return 'twig';
  }
}