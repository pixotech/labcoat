<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\ViewAll;

use Labcoat\Generator\Paths\Path;
use Labcoat\PatternLab\Styleguide\Files\Html\Page;
use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\Files\Html\Patterns\PatternPage;

class ViewAllPage extends Page implements ViewAllPageInterface {

  protected $partial;
  protected $patterns = [];

  public static function makePartial(PatternInterface $pattern) {
    $dir = $pattern->getStyleguideDirectoryName();
    return [
      'patternPartial' => $pattern->getPartial(),
      'patternName' => $pattern->getLabel(),
      'patternDescExists' => (bool)$pattern->getDescription(),
      'patternDesc' => $pattern->getDescription(),
      'patternDescAdditions' => [],
      'patternPartialCode' => $pattern->getExample(),
      'patternLink' => "$dir/$dir.html",
      'patternLineages' => PatternPage::makePatternLineage($pattern),
      'patternLineagesR' => PatternPage::makeReversePatternLineage($pattern),
      'patternEngineName' => 'Twig',
    ];
  }

  public function addPattern(PatternInterface $pattern) {
    $this->patterns[] = $pattern;
  }

  public function getContent() {
    return $this->renderer->renderPatterns($this->getPartials());
  }

  public function getPath() {
    return new Path('styleguide/html/styleguide.html');
  }

  public function getPartials() {
    $partials = [];
    foreach ($this->getPatterns() as $pattern) $partials[] = self::makePartial($pattern);
    return $partials;
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