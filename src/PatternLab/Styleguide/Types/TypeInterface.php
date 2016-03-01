<?php

namespace Labcoat\PatternLab\Styleguide\Types;

use Labcoat\PatternLab\Patterns\PatternInterface;

interface TypeInterface {

  /**
   * @param PatternInterface $pattern
   */
  public function addPattern(PatternInterface $pattern);

  /**
   * @param PatternInterface[] $patterns
   */
  public function addPatterns(array $patterns);

  /**
   * @return string
   */
  public function getId();

  /**
   * @return string
   */
  public function getLabel();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return string
   */
  public function getPartial();

  /**
   * @return PatternInterface[]
   */
  public function getPatterns();

  /**
   * @return SubtypeInterface[]
   */
  public function getSubtypes();

  /**
   * @return bool
   */
  public function hasSubtypes();
}