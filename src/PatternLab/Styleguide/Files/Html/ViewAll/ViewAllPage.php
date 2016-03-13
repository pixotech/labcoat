<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Paths\Path;
use Labcoat\PatternLab\Styleguide\Files\Html\Page;
use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\Kit\ViewAll;

class ViewAllPage extends Page implements ViewAllPageInterface {

  protected $partial;

  protected $patterns = [];

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
  }

  public function getContent() {
    return new ViewAll($this->styleguide, $this->getPatterns(), $this->getPartial());
  }

  public function getPartial() {
    return '';
  }

  public function getPath() {
    return new Path('styleguide/html/styleguide.html');
  }

  /**
   * @return PatternInterface[]
   */
  public function getPatterns() {
    return $this->patterns;
  }

  public function getTime() {
    return time();
  }
}