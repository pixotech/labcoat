<?php

namespace Labcoat\Styleguide;

use Labcoat\PatternLabInterface;
use Labcoat\Patterns\PatternInterface;
use Labcoat\Patterns\PatternSubTypeInterface;
use Labcoat\Patterns\PatternTypeInterface;

class Data {

  /**
   * @var array
   */
  protected $indexPaths = [];

  /**
   * @var array
   */
  protected $navigationItems = [];

  /**
   * @var array
   */
  protected $patternPaths = [];

  /**
   * @param PatternInterface $pattern
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
   * @param PatternSubTypeInterface $subType
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
   * @param PatternTypeInterface $type
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

  /**
   * @param PatternLabInterface $patternlab
   */
  public function __construct(PatternLabInterface $patternlab) {
    $this->makeDataArrays($patternlab);
  }

  /**
   * @return array
   */
  public function getIndexPaths() {
    return $this->indexPaths;
  }

  /**
   * @return array
   */
  public function getNavigationItems() {
    return $this->navigationItems;
  }

  /**
   * @return array
   */
  public function getPatternPaths() {
    return $this->patternPaths;
  }

  /**
   * @param PatternLabInterface $patternlab
   */
  protected function makeDataArrays(PatternLabInterface $patternlab) {

    /** @var \Labcoat\Patterns\PatternTypeInterface $type */
    foreach ($patternlab->getTypes() as $type) {
      $typeName = $type->getNameWithoutDigits();
      $typeData = self::makeTypeNavigationItem($type);

      /** @var \Labcoat\Patterns\PatternSubTypeInterface $subType */
      foreach ($type->getSubTypes() as $subType) {
        $subTypeName = $subType->getNameWithoutDigits();
        $this->indexPaths[$typeName][$subTypeName] = $subType->getStyleguidePathName();
        $subTypeData = self::makeSubTypeNavigationItem($subType);

        /** @var \Labcoat\Patterns\PatternInterface $pattern */
        foreach ($subType->getPatterns() as $pattern) {
          $patternName = $pattern->getNameWithoutDigits();
          $this->patternPaths[$typeName][$patternName] = $pattern->getStyleguidePathName();
          $subTypeData['patternSubtypeItems'][] = self::makePatternNavigationItem($pattern);
          foreach ($pattern->getPseudoPatterns() as $pseudo) {
            $pseudoName = $pseudo->getNameWithoutDigits();
            $this->patternPaths[$typeName][$pseudoName] = $pseudo->getStyleguidePathName();
            $subTypeData['patternSubtypeItems'][] = self::makePatternNavigationItem($pseudo);
          }
        }
        $typeData['patternTypeItems'][] = $subTypeData;
      }
      if (!empty($this->indexPaths[$typeName])) {
        $this->indexPaths[$typeName]['all'] = $type->getName();
      }

      /** @var \Labcoat\Patterns\PatternInterface $pattern */
      foreach ($type->getPatterns() as $pattern) {
        $patternName = $pattern->getNameWithoutDigits();
        $this->patternPaths[$typeName][$patternName] = $pattern->getStyleguidePathName();
        $typeData['patternItems'][] = self::makePatternNavigationItem($pattern);
        foreach ($pattern->getPseudoPatterns() as $pseudo) {
          $pseudoName = $pseudo->getNameWithoutDigits();
          $this->patternPaths[$typeName][$pseudoName] = $pseudo->getStyleguidePathName();
          $typeData['patternItems'][] = self::makePatternNavigationItem($pseudo);
        }
      }
      $this->navigationItems['patternTypes'][] = $typeData;
      asort($this->patternPaths[$typeName]);
    }
  }
}