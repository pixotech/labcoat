<?php

namespace Labcoat\Patterns;

interface PatternInterface {

  /**
   * @return PatternDataInterface
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
  public function getSubtype();

  /**
   * @return string
   */
  public function getStyleguidePathName();

  /**
   * @return int
   */
  public function getTime();

  public function getTemplateContent();

  public function getType();
  public function hasSubtype();
}