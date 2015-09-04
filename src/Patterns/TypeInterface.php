<?php

namespace Labcoat\Patterns;

interface TypeInterface extends PatternSectionInterface {

  /**
   * @return string
   */
  public function getId();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return bool
   */
  public function hasSubtypes();
}