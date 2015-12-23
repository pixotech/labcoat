<?php

namespace Labcoat\Styleguide\Files\Patterns;

use Labcoat\Styleguide\StyleguideInterface;

class TemplateFile extends PatternFile implements TemplateFileInterface {

  public function put(StyleguideInterface $styleguide, $path) {
    $template = $this->getTemplateContent();
    file_put_contents($path, htmlentities($template));
  }

  public function getPath() {
    return $this->pattern->getTemplatePath();
  }

  protected function getTemplateContent() {
    return file_get_contents($this->pattern->getFile());
  }

  protected function getTemplateExtension() {
    return 'twig';
  }
}