<?php

namespace Labcoat\Styleguide\Navigation;

interface TypeInterface {
  public function getLowercaseName();
  public function getName();

  /**
   * @return PatternInterface[]
   */
  public function getPatterns();

  /**
   * @return SubtypeInterface[]
   */
  public function getSubtypes();

  public function getUppercaseName();

  /**
   * @return bool
   */
  public function hasSubtypes();
}