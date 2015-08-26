<?php

namespace Labcoat\Styleguide\Files;

class PatternTemplateFile extends PatternFile implements PatternTemplateFileInterface {

  public function getContents() {
    return htmlentities($this->pattern->getTemplateContent());
  }

  public function getPath() {
    $path = $this->pattern->getStyleguidePathName();
    $ext = 'twig';
    return $this->makePath(['patterns', $path, "$path.$ext"]);
  }
}