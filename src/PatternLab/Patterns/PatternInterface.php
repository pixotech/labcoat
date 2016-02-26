<?php

namespace Labcoat\PatternLab\Patterns;

interface PatternInterface {

  public function getData();

  /**
   * @return string
   */
  public function getDescription();

  /**
   * @return string
   */
  public function getFile();

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
  public function getPath();

  /**
   * @return PseudoPatternInterface[]
   */
  public function getPseudoPatterns();

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
  public function getType();

  /**
   * @return bool
   */
  public function hasSubtype();
}