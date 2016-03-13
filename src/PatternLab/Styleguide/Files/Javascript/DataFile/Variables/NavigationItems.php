<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables;

use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;
use Labcoat\PatternLab\Patterns\Types\SubtypeInterface;
use Labcoat\PatternLab\Patterns\Types\TypeInterface;

class NavigationItems extends Variable {

  const VIEW_ALL = 'View All';

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
    return 'navItems';
  }

  /**
   * @return array
   */
  public function getValue() {
    $nav = ['patternTypes' => []];
    $types = $this->styleguide->getTypes();
    ksort($types);
    foreach ($types as $type) {
      $nav['patternTypes'][] = $this->makeNavType($type);
    }
    return $nav;
  }

  protected function makeNavPattern(PatternInterface $pattern) {
    $dir = $this->styleguide->getPatternDirectoryName($pattern);
    return [
      'patternPath' => "$dir/$dir.html",
      'patternName' => $pattern->getLabel(),
      'patternPartial' => $pattern->getPartial(),
      'patternState' => $pattern->getState(),
    ];
  }

  protected function makeNavSubtype(SubtypeInterface $subtype) {
    $data = [
      'patternSubtypeLC' => $subtype->getNameWithoutOrdering(),
      'patternSubtypeUC' => $subtype->getLabel(),
      'patternSubtype' => $subtype->getName(),
      'patternSubtypeItems' => [],
    ];
    $patterns = $subtype->getPatterns();
    ksort($patterns);
    foreach ($patterns as $pattern) {
      $data['patternSubtypeItems'][] = $this->makeNavPattern($pattern);
    }
    if (count($data['patternSubtypeItems'])) {
      $data['patternSubtypeItems'][] = $this->makeNavSubtypeItem($subtype);
    }
    return $data;
  }

  protected function makeNavSubtypeItem(SubtypeInterface $subtype) {
    $dir = $this->styleguide->getTypeDirectoryName($subtype);
    return [
      "patternPath" => "$dir/index.html",
      "patternName" => self::VIEW_ALL,
      "patternType" => $subtype->getType()->getName(),
      "patternSubtype" => $subtype->getName(),
      "patternPartial" => $subtype->getPartial(),
    ];
  }

  protected function makeNavType(TypeInterface $type) {
    $data = [
      'patternTypeLC' => $type->getNameWithoutOrdering(),
      'patternTypeUC' => $type->getLabel(),
      'patternType' => $type->getName(),
      'patternTypeItems' => [],
      'patternItems' => [],
    ];
    $subtypes = $type->getSubtypes();
    ksort($subtypes);
    foreach ($subtypes as $subtype) {
      $data['patternTypeItems'][] = $this->makeNavSubtype($subtype);
    }
    $patterns = $type->getPatterns();
    ksort($patterns);
    foreach ($patterns as $pattern) {
      $data['patternItems'][] = $this->makeNavPattern($pattern);
    }
    if (count($data['patternTypeItems'])) {
      $data['patternItems'][] = $this->makeNavTypeItem($type);
    }
    return $data;
  }

  protected function makeNavTypeItem(TypeInterface $type) {
    $dir = $this->styleguide->getTypeDirectoryName($type);
    return [
      "patternPath" => "$dir/index.html",
      "patternName" => self::VIEW_ALL,
      "patternType" => $type->getName(),
      "patternSubtype" => 'all',
      "patternPartial" => $type->getPartial(),
    ];
  }
}