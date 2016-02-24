<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables;

use Labcoat\PatternLab\Styleguide\StyleguideInterface;

class ViewAllPaths extends Variable {

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
    return 'viewAllPaths';
  }

  /**
   * @return array
   */
  public function getValue() {
    $paths = [];
    foreach ($this->styleguide->getTypes() as $type) {
      $typeName = $type->getName();
      foreach ($type->getSubtypes() as $subtype) {
        $subtypeName = $subtype->getName();
        $paths[$typeName][$subtypeName] = $subtype->getId();
      }
      if ($type->hasSubtypes()) {
        $paths[$typeName]['all'] = $type->getId();
      }
    }
    return $paths;
  }
}