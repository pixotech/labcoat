<?php

namespace Labcoat\Patterns;

interface PatternInterface {

  /**
   * @return PatternData
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
   * @return array
   */
  public function getIncludedPatterns();

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
   * @return string
   */
  public function getTemplate();

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