<?php

namespace Labcoat\Patterns;

interface PatternInterface {

  /**
   * @return array
   */
  public function getData();

  /**
   * @return string
   */
  public function getFile();

  /**
   * @return string
   */
  public function getId();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return string
   */
  public function getPartial();

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
  public function getSubType();

  /**
   * @return string
   */
  public function getSubTypeId();

  /**
   * @return int
   */
  public function getTime();

  /**
   * @return string
   */
  public function getType();

  /**
   * @return string
   */
  public function getTypeId();

  /**
   * @return bool
   */
  public function hasSubType();
}