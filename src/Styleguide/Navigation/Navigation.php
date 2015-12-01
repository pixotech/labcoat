<?php

namespace Labcoat\Styleguide\Navigation;

use Labcoat\ItemInterface;
use Labcoat\PatternLabInterface;
use Labcoat\Patterns\PatternInterface as SourcePattern;
use Labcoat\Structure\SubtypeInterface as SourceSubtype;
use Labcoat\Structure\TypeInterface as SourceType;

class Navigation implements \JsonSerializable {

  /**
   * @var array
   */
  protected $indexPaths = [];

  /**
   * @var array
   */
  protected $patternPaths = [];

  /**
   * @var Type[]
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

  /**
   * @param PatternInterface $pattern
   */
  protected function addPatternPath(SourcePattern $pattern) {
    $path = explode('/', $pattern->getNormalizedPath());
    $type = array_shift($path);
    $name = $this->escapePath(array_pop($path));
    $this->patternPaths[$type][$name] = $this->makeItemPath($pattern);
    ksort($this->patternPaths[$type]);
  }

  /**
   * @param SubtypeInterface $subtype
   */
  protected function addSubtypeIndexPath(SourceSubtype $subtype) {
    $names = explode('/', $subtype->getNormalizedPath());
    list($type, $name) = $names;
    if (!isset($this->indexPaths[$type])) {
      $typePath = array_shift(explode(DIRECTORY_SEPARATOR, $subtype->getPath()));
      $this->indexPaths[$type] = ['all' => $typePath];
      ksort($this->indexPaths);
    }
    $this->indexPaths[$type][$name] = $this->makeItemPath($subtype);
    ksort($this->indexPaths[$type]);
  }

  protected function makeItemPath(ItemInterface $item) {
    return $this->escapePath($item->getPath());
  }
}
