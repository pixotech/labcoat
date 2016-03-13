<?php

namespace Labcoat\PatternLab\Styleguide\Files\Html\Patterns;

use Labcoat\Generator\Paths\Path;
use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\Files\Html\Page;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

class PatternPage extends Page implements PatternPageInterface {

  /**
   * @var PatternInterface
   */
  protected $pattern;

  public function __construct(StyleguideInterface $styleguide, PatternInterface $pattern) {
    parent::__construct($styleguide);
    $this->pattern = $pattern;
  }

  public function getContent() {
    return $this->pattern->getExample();
  }

  public function getData() {
    return [
      'patternExtension' => 'twig',
      'cssEnabled' => false,
      'extraOutput' => [],
      'patternName' => $this->pattern->getLabel(),
      'patternPartial' => $this->pattern->getPartial(),
      'patternState' => $this->pattern->hasState() ? $this->pattern->getState() : '',
      'patternStateExists' => $this->pattern->hasState(),
      'patternDesc' => $this->pattern->getDescription(),
      'patternDescExists' => (bool)$this->pattern->hasDescription(),
      'lineage' => $this->getPatternLineage(),
      'lineageR' => $this->getPatternReverseLineage(),
    ];
  }

  public function getPath() {
    $dir = $this->getPatternDirectoryName();
    return new Path("patterns/$dir/$dir.html");
  }

  public function getPattern() {
    return $this->pattern;
  }

  public function getPatternLineage() {
    $pattern = $this->getPattern();
    return $pattern->hasLineage() ? $pattern->getLineage() : [];
  }

  public function getPatternReverseLineage() {
    $pattern = $this->getPattern();
    return $pattern->hasReverseLineage() ? $pattern->getReverseLineage() : [];
  }

  public function getTime() {
    return time();
  }

  protected function getPatternDirectoryName() {
    $pattern = $this->getPattern();
    $parts = [$pattern->getType()];
    if ($pattern->hasSubtype()) $parts[] = $pattern->getSubtype();
    $parts[] = $pattern->getName();
    return implode('-', $parts);
  }
}