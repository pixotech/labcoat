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
  public function hasState();

  /**
   * @return bool
   */
  public function hasSubtype();
}