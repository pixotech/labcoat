<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile;

use Labcoat\Generator\Files\File;
use Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables\Configuration;
use Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables\NavigationItems;
use Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables\PatternPaths;
use Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables\Plugins;
use Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables\ViewAllPaths;
use Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables\ViewportControls;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

class DataFile extends File implements DataFileInterface {

  /**
   * @var StyleguideInterface
   */
  protected $styleguide;

  public function __construct(StyleguideInterface $styleguide) {
    $this->styleguide = $styleguide;
  }

  public function getContents() {
    return implode("\n\n", $this->getVariables());
  }

  public function getPath() {
    return $this->makePath(['styleguide', 'data', 'patternlab-data.js']);
  }

  public function getTime() {
    return time();
  }

  public function put($path) {
    file_put_contents($path, $this->getContents());
  }

  protected function getVariables() {
    return [
      'config' => new Configuration($this->styleguide),
      'ishControls' => new ViewportControls($this->styleguide),
      'navItems' => new NavigationItems($this->styleguide),
      'patternPaths' => new PatternPaths($this->styleguide),
      'viewAllPaths' => new ViewAllPaths($this->styleguide),
      'plugins' => new Plugins(),
    ];
  }
}