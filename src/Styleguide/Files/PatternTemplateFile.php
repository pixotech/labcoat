<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Styleguide\StyleguideInterface;

class PatternTemplateFile extends PatternFile implements PatternTemplateFileInterface {

  public function put(StyleguideInterface $styleguide, $path) {
    $template = $this->getTemplateContent();
    file_put_contents($path, htmlentities($template));
  }

  public function getPath() {
    return $this->makePath($this->pattern->getFilePath($this->getTemplateExtension()));
  }

  protected function getTemplateContent() {
    return file_get_contents($this->pattern->getFile());
  }

  protected function getTemplateExtension() {
    return 'twig';
  }
}