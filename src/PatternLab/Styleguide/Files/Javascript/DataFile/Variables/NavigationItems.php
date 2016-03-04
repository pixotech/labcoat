<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables;

use Labcoat\PatternLab\PatternLab;
use Labcoat\PatternLab\Patterns\PatternInterface;
use Labcoat\PatternLab\Styleguide\StyleguideInterface;
use Labcoat\PatternLab\Styleguide\Types\SubtypeInterface;
use Labcoat\PatternLab\Styleguide\Types\TypeInterface;

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
    $dir = $pattern->getStyleguideDirectoryName();
    return [
      'patternPath' => "$dir/$dir.html",
      'patternName' => $pattern->getLabel(),
      'patternPartial' => $pattern->getPartial(),
      'patternState' => $pattern->getState(),
    ];
  }

  protected function makeNavSubtype(SubtypeInterface $subtype) {
    $data = [
      'patternSubtypeLC' => PatternLab::stripOrdering($subtype->getName()),
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
    $dir = $subtype->getStyleguideDirectoryName();
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
      'patternTypeLC' => PatternLab::stripOrdering($type->getName()),
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
    $dir = $type->getStyleguideDirectoryName();
    return [
      "patternPath" => "$dir/index.html",
      "patternName" => self::VIEW_ALL,
      "patternType" => $type->getName(),
      "patternSubtype" => 'all',
      "patternPartial" => $type->getPartial(),
    ];
  }
}