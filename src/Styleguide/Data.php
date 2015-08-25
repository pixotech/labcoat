<?php

namespace Labcoat\Styleguide;

use Labcoat\PatternLabInterface;

class Data {

  protected $patternlab;

  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
  }

  public function __toString() {
    return $this->contents();
  }

  public function write($path) {

    // default var
    $dataDir = $this->getStyleguideDataPath();

    // double-check that the data directory exists
    if (!is_dir($dataDir)) {
      mkdir($dataDir, 0777, true);
    }

    file_put_contents($dataDir."/patternlab-data.js", $this->contents());
  }

  protected function contents() {
    $output  = $this->makeConfig();
    $output .= $this->makeControls();
    $output .= $this->makeNavigationItems();

    $output .= $this->makePlugins();
    return $output;




    // load and write out the items for the pattern paths
    $patternPaths = array();
    $ppdExporter  = new PatternPathDestsExporter();
    $patternPaths = $ppdExporter->run();
    $output      .= "var patternPaths = ".json_encode($patternPaths).";";

    // load and write out the items for the view all paths
    $viewAllPaths = array();
    $vapExporter  = new ViewAllPathsExporter();
    $viewAllPaths = $vapExporter->run($navItems);
    $output      .= "var viewAllPaths = ".json_encode($viewAllPaths).";";
    return $output;
  }

  protected function makeConfig() {
    return "var config = ".json_encode($this->patternlab->getExposedOptions()).";";
  }

  protected function makeControls() {
    $controls = [
      'ishControlsHide' => [],
      'mqs' => $this->patternlab->getMediaQueries(),
    ];
    foreach ($this->patternlab->getHiddenControls() as $control) {
      $controls['ishControlsHide'][$control] = 'true';
    }
    return "var ishControls = " . json_encode($controls) . ";";
  }

  protected function makeNavigationItems() {
    $navigation = new Navigation($this->patternlab);
    return "var navItems = " . json_encode($navigation) . ";";
  }

  protected function makePlugins() {
    $plugins = [];
    return "var plugins = " . json_encode($plugins) . ";";
  }
}