<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\Styleguide\Navigation\Navigation;
use Labcoat\Styleguide\StyleguideInterface;

class DataFile extends File implements DataFileInterface {

  protected $navigation;

  public function __construct(Navigation $navigation) {
    $this->navigation = $navigation;
  }

  public function put(StyleguideInterface $styleguide, $path) {
    file_put_contents($path, $this->getContents($styleguide));
  }

  public function getContents(StyleguideInterface $styleguide) {
    $contents  = "var config = " . json_encode($styleguide->getConfig()).";";
    $contents .= "var ishControls = " . json_encode($styleguide->getControls()) . ";";
    $contents .= "var navItems = " . json_encode($this->navigation) . ";";
    $contents .= "var patternPaths = " . json_encode($styleguide->getPatternPaths()) . ";";
    $contents .= "var viewAllPaths = " . json_encode($styleguide->getIndexPaths()) . ";";
    $contents .= "var plugins = " . json_encode($styleguide->getPlugins()) . ";";
    return $contents;
  }

  public function getPath() {
    return $this->makePath(['styleguide', 'data', 'patternlab-data.js']);
  }

  public function getTime() {
    // TODO: Implement getTime() method.
  }
}