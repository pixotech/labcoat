<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\PatternLab;
use Labcoat\PatternLabInterface;
use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PatternSubTypeInterface;
use Labcoat\Patterns\PatternTypeInterface;
use Labcoat\Styleguide\Data;
use Labcoat\Styleguide\Navigation\Navigation;
use Labcoat\Styleguide\Styleguide;

class DataFile extends File implements DataFileInterface {

  protected $indexPaths = [];

  protected $patternPaths = [];

  /**
   * @param \Labcoat\Patterns\PatternInterface $pattern
   * @return array
   */
  public static function makePatternNavigationItem(PatternInterface $pattern) {
    return [
      'patternPath' => Styleguide::makePatternPath($pattern),
      'patternSrcPath' => $pattern->getPath(),
      'patternName' => $pattern->getUppercaseName(),
      'patternState' => $pattern->getState(),
      'patternPartial' => $pattern->getPartial(),
    ];
  }

  /**
   * @param \Labcoat\Patterns\PatternSubTypeInterface $subType
   * @return array
   */
  public static function makeSubTypeNavigationItem(PatternSubTypeInterface $subType) {
    return [
      'patternSubtypeLC' => $subType->getLowercaseName(),
      'patternSubtypeUC' => $subType->getUppercaseName(),
      'patternSubtype' => $subType->getName(),
      'patternSubtypeDash' => $subType->getNameWithoutDigits(),
      'patternSubtypeItems' => [],
    ];
  }

  /**
   * @param \Labcoat\Patterns\PatternTypeInterface $type
   * @return array
   */
  public static function makeTypeNavigationItem(PatternTypeInterface $type) {
    return [
      'patternTypeLC' => $type->getLowercaseName(),
      'patternTypeUC' => $type->getUppercaseName(),
      'patternType' => $type->getName(),
      'patternTypeDash' => $type->getNameWithoutDigits(),
      'patternTypeItems' => [],
      'patternItems' => [],
    ];
  }

  public function __construct(PatternLabInterface $patternlab = null) {
    $this->patternlab = $patternlab;
  }

  public function addPatternPath(PatternInterface $pattern) {
    $typeName = PatternLab::stripDigits($pattern->getType());
    $patternName = $pattern->getNameWithoutDigits();
    $this->patternPaths[$typeName][$patternName] = $pattern->getStyleguidePathName();
  }

  public function addSubtypeIndexPath(PatternSubTypeInterface $subtype) {
    $typeName = $subtype->getType()->getNameWithoutDigits();
    $subtypeName = $subtype->getNameWithoutDigits();
    $this->indexPaths[$typeName][$subtypeName] = $subtype->getStyleguidePathName();
  }







  public function getContents() {
    $contents  = "var config = " . json_encode($this->getConfig()).";";
    $contents .= "var ishControls = " . json_encode($this->getControls()) . ";";
    $contents .= "var navItems = " . json_encode($this->getData()->getNavigationItems()) . ";";
    $contents .= "var patternPaths = " . json_encode($this->getData()->getPatternPaths()) . ";";
    $contents .= "var viewAllPaths = " . json_encode($this->getData()->getIndexPaths()) . ";";
    $contents .= "var plugins = " . json_encode($this->getPlugins()) . ";";
    return $contents;
  }

  public function getPath() {
    return $this->makePath(['styleguide', 'data', 'patternlab-data.js']);
  }

  public function getTime() {
    // TODO: Implement getTime() method.
  }

  protected function getConfig() {
    return $this->patternlab->getExposedOptions();
  }

  protected function getData() {
    if (!isset($this->data)) $this->data = new Data($this->patternlab);
    return $this->data;
  }

  protected function getControls() {
    $controls = [
      'ishControlsHide' => [],
      'mqs' => $this->getMediaQueries(),
    ];
    foreach ($this->getHiddenControls() as $control) {
      $controls['ishControlsHide'][$control] = 'true';
    }
    return $controls;
  }

  protected function getHiddenControls() {
    return [];
    return $this->patternlab->getHiddenControls();
  }

  protected function getMediaQueries() {
    $mediaQueries = [];
    foreach ($this->getStylesheets() as $file) {
      $data = file_get_contents($file->getPathname());
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

  protected function getPlugins() {
    return [];
  }

  /**
   * @return \SplFileInfo[]
   */
  protected function getStylesheets() {
    return [];
  }
}