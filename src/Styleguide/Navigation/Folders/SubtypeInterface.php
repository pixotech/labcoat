<?php

namespace Labcoat\Styleguide\Navigation\Folders;

use Labcoat\Styleguide\Navigation\PatternInterface;

interface SubtypeInterface extends FolderInterface {

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
}