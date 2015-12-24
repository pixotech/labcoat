<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\PatternLab\Styleguide\Files\Html\Page;
use Labcoat\PatternLab\Patterns\PatternInterface;

class ViewAllPage extends Page implements ViewAllPageInterface {

  protected $partial;
  protected $patterns = [];
  protected $time;

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
    $this->time = max($this->time, $pattern->getTime());
  }

  public function getDocumentContent() {
    $variables = [
      'partials' => $this->getPatterns(),
      'patternPartial' => '',
    ];
    return $this->render('viewall', $variables);
  }

  public function getPath() {
    return ['styleguide', 'html', 'styleguide.html'];
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