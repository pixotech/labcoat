<?php

namespace Labcoat\Patterns;

interface SubtypeInterface extends PatternSectionInterface {

  /**
   * @return string
   */
  public function getId();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return TypeInterface
   */
  public function getType();

  /**
   * @return string
   */
  public function getTypeId();
}