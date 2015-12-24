<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Paths\Path;
use Labcoat\PatternLab\Styleguide\Files\Html\Page;
use Labcoat\PatternLab\Patterns\PatternInterface;

class ViewAllPage extends Page implements ViewAllPageInterface {

  protected $partial;
  protected $patterns = [];
  protected $time = 0;

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
    $this->time = max($this->time, $pattern->getTime());
  }

  public function getContent() {
    return $this->styleguide->render('viewall', $this->getContentVariables());
  }

  public function getContentVariables() {
    return [
      'partials' => $this->getPatterns(),
      'patternPartial' => '',
    ];
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
    return $this->time;
  }
}