<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\PatternLab;
use Labcoat\PatternLabInterface;
use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PatternSubTypeInterface;
use Labcoat\Patterns\PatternTypeInterface;
use Labcoat\Styleguide\Data;
use Labcoat\Styleguide\Navigation\Navigation;
use Labcoat\Styleguide\Navigation\Pattern as NavigationPattern;
use Labcoat\Styleguide\Styleguide;
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

  public function getIndexPaths() {
    return $this->indexPaths;
  }

  public function getPatternPaths() {
    return $this->patternPaths;
  }




  public function getPath() {
    return $this->makePath(['styleguide', 'data', 'patternlab-data.js']);
  }

  public function getTime() {
    // TODO: Implement getTime() method.
  }

  protected function getConfig() {
    return $this->patternlab->getExposedOptions();
  }

  protected function getData() {
    if (!isset($this->data)) $this->data = new Data($this->patternlab);
    return $this->data;
  }

  protected function getControls() {
    $controls = [
      'ishControlsHide' => [],
      'mqs' => $this->getMediaQueries(),
    ];
    foreach ($this->getHiddenControls() as $control) {
      $controls['ishControlsHide'][$control] = 'true';
    }
    return $controls;
  }

  protected function getHiddenControls() {
    return [];
    return $this->patternlab->getHiddenControls();
  }

  protected function getMediaQueries() {
    $mediaQueries = [];
    foreach ($this->getStylesheets() as $file) {
      $data = file_get_contents($file->getPathname());
      preg_match_all("/@media.*(min|max)-width:([ ]+)?(([0-9]{1,5})(\.[0-9]{1,20}|)(px|em))/", $data, $matches);
      foreach ($matches[3] as $match) {
        if (!in_array($match, $mediaQueries)) {
          $mediaQueries[] = $match;
        }
      }
    }
    usort($mediaQueries, "strnatcmp");
    return $mediaQueries;
  }

  protected function getPlugins() {
    return [];
  }

  /**
   * @return \SplFileInfo[]
   */
  protected function getStylesheets() {
    return [];
  }
}