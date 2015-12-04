<?php

namespace Labcoat\Styleguide\Files;

use Labcoat\PatternLabInterface;
use Labcoat\Patterns\PatternInterface;
use Labcoat\Structure\FolderInterface;
use Labcoat\Structure\SubtypeInterface;
use Labcoat\Structure\TypeInterface;
use Labcoat\Styleguide\Navigation\Navigation;
use Labcoat\Styleguide\StyleguideInterface;

class DataFile extends File implements DataFileInterface {

  /**
   * @var array
   */
  protected $config;

  /**
   * @var array
   */
  protected $controls;

  /**
   * @var Navigation
   */
  protected $navigation;

  /**
   * @var PatternLabInterface
   */
  protected $patternlab;

  public static function makeNavPattern(PatternInterface $pattern) {
    return [
      'patternPath' => $pattern->getPagePath(),
      'patternName' => $pattern->getLabel(),
      'patternPartial' => $pattern->getPartial(),
      'patternState' => $pattern->getState(),
    ];
  }

  public static function makeNavSubtype(SubtypeInterface $subtype) {
    $data = [
      'patternSubtypeLC' => $subtype->getName(),
      'patternSubtypeUC' => $subtype->getLabel(),
      'patternSubtype' => $subtype->getName(),
      'patternSubtypeItems' => [],
    ];
    foreach ($subtype->getPatterns() as $pattern) {
      $data['patternSubtypeItems'][] = self::makeNavPattern($pattern);
    }
    if (count($data['patternSubtypeItems'])) {
      $data['patternSubtypeItems'][] = self::makeNavSubtypeItem($subtype);
    }
    return $data;
  }

  public static function makeNavSubtypeItem(SubtypeInterface $subtype) {
    return [
      "patternPath" => $subtype->getName(),
      "patternName" => $subtype->getName(),
      "patternType" => $subtype->getType()->getName(),
      "patternSubtype" => $subtype->getName(),
      "patternPartial" => $subtype->getPartial(),
    ];
  }

  public static function makeNavType(TypeInterface $type) {
    $data = [
      'patternTypeLC' => $type->getName(),
      'patternTypeUC' => $type->getLabel(),
      'patternType' => $type->getName(),
      'patternTypeItems' => [],
      'patternItems' => [],
    ];
    foreach ($type->getSubtypes() as $subtype) {
      $data['patternTypeItems'][] = self::makeNavSubtype($subtype);
    }
    foreach ($type->getPatterns() as $pattern) {
      $data['patternItems'][] = self::makeNavPattern($pattern);
    }
    if (count($data['patternTypeItems'])) {
      $data['patternItems'][] = self::makeNavTypeItem($type);
    }
    return $data;
  }

  public static function makeNavTypeItem(TypeInterface $type) {
    return [
      "patternPath" => $type->getName(),
      "patternName" => $type->getName(),
      "patternType" => $type->getName(),
      "patternSubtype" => 'all',
      "patternPartial" => $type->getPartial(),
    ];
  }

  public function __construct(PatternLabInterface $patternlab) {
    $this->patternlab = $patternlab;
    $this->loadControls();
  }

  /**
   * @param StyleguideInterface $styleguide
   * @return array
   */
  public function getConfig(StyleguideInterface $styleguide) {
    return [
      'cacheBuster' => $styleguide->getCacheBuster(),
      'ishMaximum' => $styleguide->getMaximumWidth(),
      'ishMinimum' => $styleguide->getMinimumWidth(),
    ];
  }

  /**
   * @return array
   */
  public function getControls() {
    return $this->controls;
  }

  public function getContents(StyleguideInterface $styleguide) {
    $contents  = "var config = " . json_encode($this->getConfig($styleguide)).";";
    $contents .= "var ishControls = " . json_encode($this->getControls()) . ";";
    $contents .= "var navItems = " . json_encode($this->getNavItems()) . ";";
    $contents .= "var patternPaths = " . json_encode($this->navigation->getPatternPaths()) . ";";
    $contents .= "var viewAllPaths = " . json_encode($this->navigation->getViewAllPaths()) . ";";
    $contents .= "var plugins = " . json_encode($this->getPlugins()) . ";";
    return $contents;
  }

  public function getNavItems() {
    $nav = ['patternTypes' => []];
    foreach ($this->patternlab->getTypes() as $type) {
      $nav['patternTypes'][] = self::makeNavType($type);
    }
    return $nav;
  }

  public function getPath() {
    return $this->makePath(['styleguide', 'data', 'patternlab-data.js']);
  }

  public function getTime() {
    return time();
  }

  public function put(StyleguideInterface $styleguide, $path) {
    file_put_contents($path, $this->getContents($styleguide));
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
  protected function getPlugins() {
    return [];
  }

  /**
   * @return array
   */
  protected function getStylesheets() {
    if (!isset($this->stylesheets)) {
      $this->stylesheets = [];
      foreach ($this->patternlab->getAssets() as $asset) {
        if (pathinfo($asset->getPath(), PATHINFO_EXTENSION) == 'css') {
          $this->stylesheets[] = $asset->getFile();
        }
      }
    }
    return $this->stylesheets;
  }

  protected function loadControls() {
    $this->controls = [
      'ishControlsHide' => [],
      'mqs' => $this->getMediaQueries(),
    ];
    foreach ($this->patternlab->getHiddenControls() as $control) {
      $this->controls['ishControlsHide'][$control] = 'true';
    }
  }
}