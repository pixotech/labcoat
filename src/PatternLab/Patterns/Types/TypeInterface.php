<?php

namespace Labcoat\PatternLab\Patterns\Types;

use Labcoat\PatternLab\Patterns\PatternInterface;

interface TypeInterface {

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
  public function getNameWithoutOrdering();

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