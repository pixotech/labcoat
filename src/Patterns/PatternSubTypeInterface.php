<?php

namespace Labcoat\Patterns;

interface PatternSubTypeInterface {

  /**
   * @return string
   */
  public function getId();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return PatternTypeInterface
   */
  public function getType();

  /**
   * @return string
   */
  public function getTypeId();
}