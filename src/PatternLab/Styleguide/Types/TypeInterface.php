<?php

namespace Labcoat\PatternLab\Styleguide\Types;

use Labcoat\PatternLab\Styleguide\Patterns\PatternInterface;

/*

Type properties:

  Lowercase name
    The name of the type with ordering removed and dashes converted to spaces
    Used in the class name of the type's navigation item

  Uppercase name
    The lowercase name, with all words capitalized
    Used as the label for the type's navigation item

 */

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