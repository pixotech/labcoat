<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\PatternLabInterface;
use Labcoat\Styleguide\Navigation\Navigation;
use Labcoat\Styleguide\StyleguideInterface;

class DataFile extends File implements DataFileInterface {

  /**
   * @var array
   */
  protected $config;

  /**
   * @var array
   */
  protected $controls;

  /**
   * @var Navigation
   */
  protected $navigation;

  /**
   * @var PatternLabInterface
   */
  protected $patternlab;

  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
    $this->loadConfig();
    $this->loadControls();
    $this->makeNavigation();
  }

  /**
   * @return array
   */
  public function getConfig() {
    return $this->config;
  }

  /**
   * @return array
   */
  public function getControls() {
    return $this->controls;
  }

  public function getContents() {
    $contents  = "var config = " . json_encode($this->getConfig()).";";
    $contents .= "var ishControls = " . json_encode($this->getControls()) . ";";
    $contents .= "var navItems = " . json_encode($this->navigation) . ";";
    $contents .= "var patternPaths = " . json_encode($this->navigation->getPatternPaths()) . ";";
    $contents .= "var viewAllPaths = " . json_encode($this->navigation->getIndexPaths()) . ";";
    $contents .= "var plugins = " . json_encode($this->getPlugins()) . ";";
    return $contents;
  }

  public function getPath() {
    return $this->makePath(['styleguide', 'data', 'patternlab-data.js']);
  }

  public function getTime() {
    return time();
  }

  public function put(StyleguideInterface $styleguide, $path) {
    file_put_contents($path, $this->getContents());
  }

  /**
   * @return array
   */
  protected function getMediaQueries() {
    $mediaQueries = [];
    foreach ($this->getStylesheets() as $path) {
      $data = file_get_contents($path);
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

  /**
   * @return array
   */
  protected function getPlugins() {
    return [];
  }

  /**
   * @return array
   */
  protected function getStylesheets() {
    if (!isset($this->stylesheets)) {
      $this->stylesheets = [];
      foreach ($this->patternlab->getAssets() as $asset) {
        if (pathinfo($asset->getPath(), PATHINFO_EXTENSION) == 'css') {
          $this->stylesheets[] = $asset->getFile();
        }
      }
    }
    return $this->stylesheets;
  }

  protected function loadConfig() {
    $this->config = $this->patternlab->getExposedOptions();
  }

  protected function loadControls() {
    $this->controls = [
      'ishControlsHide' => [],
      'mqs' => $this->getMediaQueries(),
    ];
    foreach ($this->patternlab->getHiddenControls() as $control) {
      $this->controls['ishControlsHide'][$control] = 'true';
    }
  }

  protected function makeNavigation() {
    $this->navigation = new Navigation($this->patternlab);
  }
}