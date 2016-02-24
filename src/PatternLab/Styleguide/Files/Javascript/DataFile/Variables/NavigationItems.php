<?php

namespace Labcoat\PatternLab\Styleguide\Files\Javascript\DataFile\Variables;

use Labcoat\PatternLab\Styleguide\Patterns\PatternInterface;
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
    foreach ($this->styleguide->getTypes() as $type) {
      $nav['patternTypes'][] = $this->makeNavType($type);
    }
    return $nav;
  }

  protected function makeNavPattern(PatternInterface $pattern) {
    $id = $pattern->getId();
    return [
      'patternPath' => "$id/$id.html",
      'patternName' => $pattern->getLabel(),
      'patternPartial' => $pattern->getPartial(),
      'patternState' => $pattern->getState(),
    ];
  }

  protected function makeNavSubtype(SubtypeInterface $subtype) {
    $data = [
      'patternSubtypeLC' => $subtype->getName(),
      'patternSubtypeUC' => $subtype->getLabel(),
      'patternSubtype' => $subtype->getName(),
      'patternSubtypeItems' => [],
    ];
    foreach ($subtype->getPatterns() as $pattern) {
      $data['patternSubtypeItems'][] = $this->makeNavPattern($pattern);
    }
    if (count($data['patternSubtypeItems'])) {
      $data['patternSubtypeItems'][] = $this->makeNavSubtypeItem($subtype);
    }
    return $data;
  }

  protected function makeNavSubtypeItem(SubtypeInterface $subtype) {
    $id = $subtype->getId();
    return [
      "patternPath" => "$id/index.html",
      "patternName" => self::VIEW_ALL,
      "patternType" => $subtype->getType()->getId(),
      "patternSubtype" => $subtype->getName(),
      "patternPartial" => $subtype->getPartial(),
    ];
  }

  protected function makeNavType(TypeInterface $type) {
    $data = [
      'patternTypeLC' => $type->getName(),
      'patternTypeUC' => $type->getLabel(),
      'patternType' => $type->getId(),
      'patternTypeItems' => [],
      'patternItems' => [],
    ];
    foreach ($type->getSubtypes() as $subtype) {
      $data['patternTypeItems'][] = $this->makeNavSubtype($subtype);
    }
    foreach ($type->getPatterns() as $pattern) {
      $data['patternItems'][] = $this->makeNavPattern($pattern);
    }
    if (count($data['patternTypeItems'])) {
      $data['patternItems'][] = $this->makeNavTypeItem($type);
    }
    return $data;
  }

  protected function makeNavTypeItem(TypeInterface $type) {
    $id = $type->getId();
    return [
      "patternPath" => "$id/index.html",
      "patternName" => self::VIEW_ALL,
      "patternType" => $type->getId(),
      "patternSubtype" => 'all',
      "patternPartial" => $type->getPartial(),
    ];
  }
}