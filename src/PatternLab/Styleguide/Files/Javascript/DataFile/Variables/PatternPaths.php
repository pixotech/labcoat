<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables;

use Labcoat\PatternLab\PatternLab;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

class PatternPaths extends Variable {

  /**
   * @var StyleguideInterface
   */
  protected $styleguide;

  /**
   * @param StyleguideInterface $styleguide
   */
  public function __construct(StyleguideInterface $styleguide) {
    $this->styleguide = $styleguide;
  }

  /**
   * @return string
   */
  public function getName() {
    return 'patternPaths';
  }

  /**
   * @return array
   */
  public function getValue() {
    $paths = [];
    foreach ($this->styleguide->getTypes() as $type) {
      $typeName = PatternLab::stripOrdering($type->getName());
      foreach ($type->getSubtypes() as $subtype) {
        foreach ($subtype->getPatterns() as $pattern) {
          $patternName = PatternLab::stripOrdering($pattern->getName());
          $paths[$typeName][$patternName] = $pattern->getStyleguideDirectoryName();
        }
      }
      foreach ($type->getPatterns() as $pattern) {
        $patternName = PatternLab::stripOrdering($pattern->getName());
        $paths[$typeName][$patternName] = $pattern->getStyleguideDirectoryName();
      }
    }
    return $paths;
  }
}