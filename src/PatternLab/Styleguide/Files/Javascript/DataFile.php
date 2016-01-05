<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript;

use Labcoat\PatternLabInterface;
use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Patterns\Types\SubtypeInterface;
use Labcoat\PatternLab\Patterns\Types\TypeInterface;
use Labcoat\Generator\Files\File;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;

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
   * @var PatternLabInterface
   */
  protected $patternlab;

  /**
   * @var StyleguideInterface
   */
  protected $styleguide;

  public static function makeNavPattern(PatternInterface $pattern) {
    $id = $pattern->getId();
    return [
      'patternPath' => "$id/$id.html",
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

  public function __construct(StyleguideInterface $styleguide, PatternLabInterface $patternlab) {
    $this->styleguide = $styleguide;
    $this->patternlab = $patternlab;
    $this->loadControls();
  }

  /**
   * @param StyleguideInterface $styleguide
   * @return array
   */
  public function getConfig() {
    return [
      'cacheBuster' => $this->styleguide->getCacheBuster(),
      'ishMaximum' => $this->styleguide->getMaximumWidth(),
      'ishMinimum' => $this->styleguide->getMinimumWidth(),
    ];
  }

  /**
   * @return array
   */
  public function getControls() {
    return $this->controls;
  }

  public function getContents() {
    $contents  = "var config = " . $this->jsonEncode($this->getConfig()).";\n\n";
    $contents .= "var ishControls = " . $this->jsonEncode($this->getControls()) . ";\n\n";
    $contents .= "var navItems = " . $this->jsonEncode($this->getNavItems()) . ";\n\n";
    $contents .= "var patternPaths = " . $this->jsonEncode($this->getPatternPaths()) . ";\n\n";
    $contents .= "var viewAllPaths = " . $this->jsonEncode($this->getViewAllPaths()) . ";\n\n";
    $contents .= "var plugins = " . $this->jsonEncode($this->getPlugins()) . ";";
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

  public function getPatternPaths() {
    $paths = [];
    foreach ($this->patternlab->getTypes() as $type) {
      $typeName = $type->getName();
      foreach ($type->getSubtypes() as $subtype) {
        foreach ($subtype->getPatterns() as $pattern) {
          $patternName = $pattern->getName();
          $paths[$typeName][$patternName] = $pattern->getId();
        }
      }
      foreach ($type->getPatterns() as $pattern) {
        $patternName = (string)$pattern->getName();
        $paths[$typeName][$patternName] = $pattern->getId();
      }
    }
    return $paths;
  }

  public function getTime() {
    return time();
  }

  public function getViewAllPaths() {
    $paths = [];
    foreach ($this->patternlab->getTypes() as $type) {
      $typeName = $type->getId();
      foreach ($type->getSubtypes() as $subtype) {
        $subtypeName = $subtype->getId();
        $paths[$typeName][$subtypeName] = $subtype->getPartial();
      }
      if ($type->hasSubtypes()) {
        $paths[$typeName]['all'] = $type->getName();
      }
    }
    return $paths;
  }

  public function put($path) {
    file_put_contents($path, $this->getContents());
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
    }
    return $this->stylesheets;
  }

  protected function jsonEncode($var) {
    return json_encode($var, JSON_PRETTY_PRINT);
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