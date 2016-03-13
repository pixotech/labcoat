<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables;

use Labcoat\PatternLab\Styleguide\Files\Javascript\Variable;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

class Configuration extends Variable {

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
    return 'config';
  }

  /**
   * @return array
   */
  public function getValue() {
    return [
      'cacheBuster' => $this->styleguide->getCacheBuster(),
      'ishMaximum' => $this->styleguide->getMaximumWidth(),
      'ishMinimum' => $this->styleguide->getMinimumWidth(),
    ];
  }
}