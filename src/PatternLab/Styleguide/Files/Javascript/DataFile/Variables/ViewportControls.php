<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables;

use Labcoat\PatternLab\Styleguide\StyleguideInterface;

class ViewportControls extends Variable {

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
    return 'ishControls';
  }

  /**
   * @return array
   */
  public function getValue() {
    $controls = [
      'ishControlsHide' => [],
      'mqs' => $this->getMediaQueries(),
    ];
    foreach ($this->styleguide->getHiddenControls() as $control) {
      $controls['ishControlsHide'][$control] = 'true';
    }
    # Things break if no controls are hidden; we'll hide disco, because disco is dead
    if (empty($controls['ishControlsHide'])) $controls['ishControlsHide'][] = 'disco';
    return $controls;
  }

  /**
   * @return array
   */
  protected function getMediaQueries() {
    return $this->styleguide->getBreakpoints();
  }
}