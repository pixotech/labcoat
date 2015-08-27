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
  public function getDisplayName();

  /**
   * @return string
   */
  public function getFile();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return string
   */
  public function getPartial();

  public function getPath();

  /**
   * @return string
   */
  public function getState();

  /**
   * @return string
   */
  public function getStyleguidePathName();

  public function getSubType();

  /**
   * @return int
   */
  public function getTime();

  public function getTemplateContent();

  public function getType();
  public function hasSubType();
}