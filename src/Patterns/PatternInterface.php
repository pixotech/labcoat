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
  public function getPartial();

  /**
   * @return string
   */
  public function getPath();

  /**
   * @return string
   */
  public function getState();

  /**
   * @return string
   */
  public function getStyleguidePathName();

  /**
   * @return string
   */
  public function getSubType();

  /**
   * @return int
   */
  public function getTime();

  /**
   * @return string
   */
  public function getTemplate();

  /**
   * @return string
   */
  public function getTemplateContent();

  /**
   * @return string
   */
  public function getType();

  /**
   * @return string
   */
  public function getUppercaseName();

  /**
   * @return bool
   */
  public function hasSubType();
}