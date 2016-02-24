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
    return $controls;
  }

  /**
   * @return array
   */
  protected function getMediaQueries() {
    return $this->getMediaQueriesFromStylesheet();
  }

  protected function getMediaQueriesFromStylesheet() {
    $mediaQueries = [];
    foreach ($this->getStylesheets() as $path) {
      $data = file_get_contents($path);
      preg_match_all("/@media.*(min|max)-width:([ ]+)?(([0-9]{1,5})(\.[0-9]{1,20}|)(px|em))/", $data, $matches);
      foreach ($matches[3] as $match) {
        if (!in_array($match, $mediaQueries)) {
          $mediaQueries[] = $match;
        }
      }
    }
    usort($mediaQueries, "strnatcmp");
    return $mediaQueries;
  }

  /**
   * @return array
   */
  protected function getStylesheets() {
    if (!isset($this->stylesheets)) {
      $this->stylesheets = [];
    }
    return $this->stylesheets;
  }
}