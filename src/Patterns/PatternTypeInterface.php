<?php

namespace Labcoat\Patterns;

interface PatternTypeInterface {

  /**
   * @return \Labcoat\Patterns\PatternInterface[]
   */
  public function getAllPatterns();

  /**
   * @return string
   */
  public function getLowercaseName();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return string
   */
  public function getNameWithoutDigits();

  /**
   * @return string
   */
  public function getPath();

  /**
   * @return \Labcoat\Patterns\PatternInterface[]
   */
  public function getPatterns();

  /**
   * @return \Labcoat\Patterns\PatternSubTypeInterface[]
   */
  public function getSubTypes();

  /**
   * @return string
   */
  public function getUppercaseName();
}