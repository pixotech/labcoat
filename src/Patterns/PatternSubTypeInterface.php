<?php

namespace Labcoat\Patterns;

interface PatternSubTypeInterface {

  /**
   * @param \Labcoat\Patterns\PatternInterface $pattern
   */
  public function add(PatternInterface $pattern);

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
   * @return \Labcoat\Patterns\PatternInterface[]
   */
  public function getPatterns();

  /**
   * @return string
   */
  public function getStyleguidePathName();

  /**
   * @return \Labcoat\Patterns\PatternTypeInterface[]
   */
  public function getType();

  /**
   * @return string
   */
  public function getUppercaseName();
}