<?php

namespace Labcoat\PatternLab\Patterns\Types;

/*

Type properties:

  Lowercase name
    The name of the type with ordering removed and dashes converted to spaces
    Used in the class name of the type's navigation item

  Uppercase name
    The lowercase name, with all words capitalized
    Used as the label for the type's navigation item

 */

use Labcoat\PatternLab\Patterns\Types\FolderInterface;
use Labcoat\PatternLab\Patterns\Types\SubtypeInterface;

interface TypeInterface extends FolderInterface {

  /**
   * @return SubtypeInterface[]
   */
  public function getSubtypes();

  /**
   * @return bool
   */
  public function hasSubtypes();
}