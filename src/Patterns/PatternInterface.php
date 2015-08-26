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
  public function getFile();

  /**
   * @return string
   */
  public function getName();
  public function getPath();
  public function getSubtype();

  /**
   * @return string
   */
  public function getStyleguidePathName();

  public function getType();
  public function hasSubtype();
}