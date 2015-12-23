<?php

namespace Labcoat\Styleguide\Files\Html\ViewAll;

use Labcoat\Styleguide\Files\Html\Page;
use Labcoat\Styleguide\Patterns\PatternInterface;
use Labcoat\Styleguide\StyleguideInterface;

class ViewAllPage extends Page implements ViewAllPageInterface {

  protected $partial;
  protected $patterns = [];
  protected $time;

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
    $this->time = max($this->time, $pattern->getTime());
  }

  public function getDocumentContent(StyleguideInterface $styleguide) {
    $variables = [
      'partials' => $this->getPatterns(),
      'patternPartial' => '',
    ];
    return $styleguide->render('viewall', $variables);
  }

  public function getPath() {
    return ['styleguide', 'html', 'styleguide.html'];
  }

  /**
   * @return \Labcoat\Styleguide\Patterns\PatternInterface[]
   */
  public function getPatterns() {
    return $this->patterns;
  }

  public function getTime() {
    return $this->time;
  }
}