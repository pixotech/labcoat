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
  public function getType();
  public function hasSubtype();
}