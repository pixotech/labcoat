<?php

namespace Labcoat\PatternLab\Patterns;

interface PatternInterface {

  /**
   * @return string
   */
  public function getDescription();

  /**
   * @return string
   */
  public function getExample();

  /**
   * @return string
   */
  public function getLabel();

  /**
   * @return PatternInterface[]
   */
  public function getLineage();

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
  public function getReverseLineage();

  /**
   * @return string
   */
  public function getState();

  /**
   * @return string
   */
  public function getSubtype();

  /**
   * @return string
   */
  public function getTemplate();

  /**
   * @return string
   */
  public function getType();

  /**
   * @return bool
   */
  public function hasDescription();

  /**
   * @return bool
   */
  public function hasLineage();

  /**
   * @return bool
   */
  public function hasReverseLineage();

  /**
   * @return bool
   */
  public function hasState();

  /**
   * @return bool
   */
  public function hasSubtype();
}