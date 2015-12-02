<?php

namespace Labcoat\Styleguide\Navigation\Folders;

use Labcoat\Styleguide\Navigation\Items\PatternItemInterface;

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
   * @return PatternItemInterface[]
   */
  public function getPatterns();
}