<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Patterns\PatternCollectionInterface;

class StyleguideIndexFile implements StyleguideIndexFileInterface {

  protected $patterns;

  public function __construct(PatternCollectionInterface $patterns) {
    $this->patterns = $patterns;
  }

  public function getContents() {
    // TODO: Implement getContents() method.
  }

  public function getPath() {
    return implode(DIRECTORY_SEPARATOR, ['styleguide', 'html', 'styleguide.html']);
  }

  public function getTime() {
    return $this->patterns->getTime();
  }
}