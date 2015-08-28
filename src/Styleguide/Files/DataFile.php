<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\PatternLabInterface;
use Labcoat\Styleguide\Data;
use Labcoat\Styleguide\Navigation;

class DataFile extends File implements DataFileInterface {

  /**
   * @var \Labcoat\Styleguide\Data
   */
  protected $data;

  /**
   * @var PatternLabInterface
   */
  protected $patternlab;

  protected $patternPaths;

  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
  }

  public function getContents() {
    $contents  = "var config = " . json_encode($this->getConfig()).";";
    $contents .= "var ishControls = " . json_encode($this->getControls()) . ";";
    $contents .= "var navItems = " . json_encode($this->getData()->getNavigationItems()) . ";";
    $contents .= "var patternPaths = " . json_encode($this->getData()->getPatternPaths()) . ";";
    $contents .= "var viewAllPaths = " . json_encode($this->getData()->getIndexPaths()) . ";";
    $contents .= "var plugins = " . json_encode($this->getPlugins()) . ";";
    return $contents;
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