<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\PatternLabInterface;
use Labcoat\Patterns\Paths\Segment;
use Labcoat\Styleguide\Navigation\Folders\Type;

class Navigation implements NavigationInterface, \JsonSerializable {

  /**
   * @var array
   */
  protected $indexPaths = [];

  /**
   * @var array
   */
  protected $patternPaths = [];

  /**
   * @var \Labcoat\Styleguide\Navigation\Folders\TypeInterface[]
   */
  protected $types = [];

  public static function getTypeFromPath($path) {
    return array_shift(explode(DIRECTORY_SEPARATOR, $path));
  }

  public static function escapePath($path) {
    return preg_replace('|[\\\/~]|', '-', $path);
  }

  public function __construct(PatternLabInterface $patternlab) {
    foreach ($patternlab->getTypes() as $type) {
      $this->types[] = new Type($type);
    }
    $this->makePaths();
  }

  public function getIndexPaths() {
    return $this->indexPaths;
  }

  public function getPatternPaths() {
    return $this->patternPaths;
  }

  public function jsonSerialize() {
    return [
      'patternTypes' => array_values($this->types),
    ];
  }

  protected function makePaths() {
    foreach ($this->types as $navType) {
      /** @var \Labcoat\Structure\TypeInterface $type */
      $type = $navType->getFolder();
      $typeName = (string)(new Segment($type->getName()))->getName();
      foreach ($type->getSubtypes() as $subtype) {
        $subtypeName = (string)$subtype->getName();
        $this->indexPaths[$typeName][$subtypeName] = $subtype->getPartial();
        foreach ($subtype->getPatterns() as $pattern) {
          $patternName = (string)$pattern->getName();
          $this->patternPaths[$typeName][$patternName] = $pattern->getPartial();
        }
      }
      if ($type->hasSubtypes()) {
        $this->indexPaths[$typeName]['all'] = $type->getName();
      }
      foreach ($type->getPatterns() as $pattern) {
        $patternName = (string)$pattern->getName();
        $this->patternPaths[$typeName][$patternName] = $pattern->getPartial();
      }
    }
  }
}
