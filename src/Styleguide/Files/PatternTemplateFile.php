<?php

namespace Labcoat\Styleguide\Files;

class PatternTemplateFile extends PatternFile implements PatternTemplateFileInterface {

  public function getContents() {
    // TODO: Implement getContents() method.
  }

  public function getPath() {
    $path = $this->pattern->getStyleguidePathName();
    $ext = 'twig';
    return "$path/$path.$ext";
  }
}