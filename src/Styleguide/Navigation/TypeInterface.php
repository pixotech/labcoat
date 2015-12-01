<?php

namespace Labcoat\Styleguide\Navigation;

interface TypeInterface {
  public function addPattern(\Labcoat\Patterns\PatternInterface $pattern);
  public function addSubtype(\Labcoat\Structure\SubtypeInterface $subtype);
  public function getLowercaseName();
  public function getName();
  public function getNameWithDashes();

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